<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\OrderBundle\Controller\Front;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class CartAddressController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class AddressController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\OrderBundle\Manager\Front\CartManagerInterface
     */
    protected $manager;
    
    public function indexAction(Request $request) : Response
    {
        $cart = $this->manager->getCartContext()->getCurrentCart();
        $form = $this->manager->getForm($cart, [
            'validation_groups' => $this->getValidationGroupsForRequest($request)
        ]);

        if ($form->isSubmitted() && 1 === (int)$request->request->get('copyAddress')) {
            $this->copyShippingAddress($request->request);
        }

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->updateResource($cart);
                
                return $this->getRouterHelper()->redirectTo('front.order.confirm');
            }
            
            if (count($form->getError())) {
                $this->getFlashHelper()->addError('client.flash.registration.error');
            }
        }
        
        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }
    
    private function getValidationGroupsForRequest(Request $request) : array
    {
        $validationGroups = [
            'cart_client_contact_details',
            'cart_client_billing_address',
        ];
        
        if ($request->isMethod('POST') && 0 === (int)$request->request->filter('copyAddress')) {
            $validationGroups[] = 'cart_client_shipping_address';
        }
        
        return $validationGroups;
    }

    /**
     * Copies billing address to shipping address
     *
     * @param ParameterBag $parameters
     */
    private function copyShippingAddress(ParameterBag $parameters)
    {
        $billingAddress  = $parameters->get('billingAddress');
        $shippingAddress = [];

        foreach ($billingAddress as $key => $value) {
            list(, $fieldName) = explode('.', $key);
            $shippingAddress['shippingAddress.' . $fieldName] = $value;
        }

        $parameters->set('shippingAddress', $shippingAddress);
    }
}
