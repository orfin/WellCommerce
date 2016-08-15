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
 * Class OrderAddressController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderAddressController extends AbstractFrontController
{
    public function indexAction(Request $request) : Response
    {
        $order = $this->getOrderProvider()->getCurrentOrder();
        $form  = $this->getForm($order, [
            'validation_groups' => $this->getValidationGroupsForRequest($request)
        ]);
        
        if ($form->isSubmitted() && $this->isCopyBillingAddress($request)) {
            $this->copyShippingAddress($request->request);
        }
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($order);
                
                return $this->getRouterHelper()->redirectTo('front.order_confirm.index');
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
            'order_billing_address',
            'order_client_details',
            'order_contact_details',
        ];
        
        if ($request->isMethod('POST') && $this->isCopyBillingAddress($request)) {
            $validationGroups[] = 'order_shipping_address';
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
        $billingAddress = $parameters->get('billingAddress');
        
        $shippingAddress = [
            'shippingAddress.copyBillingAddress' => true
        ];
        
        foreach ($billingAddress as $key => $value) {
            list(, $fieldName) = explode('.', $key);
            $shippingAddress['shippingAddress.' . $fieldName] = $value;
        }
        
        $parameters->set('shippingAddress', $shippingAddress);
    }
    
    
    private function isCopyBillingAddress(Request $request) : bool
    {
        $shippingAddress    = $request->request->filter('shippingAddress');
        $copyBillingAddress = $shippingAddress['shippingAddress.copyBillingAddress'] ?? 0;
        
        return 1 === (int)$copyBillingAddress;
    }
}
