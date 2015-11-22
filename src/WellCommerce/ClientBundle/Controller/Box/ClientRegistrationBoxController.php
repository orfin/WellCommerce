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

namespace WellCommerce\ClientBundle\Controller\Box;

use WellCommerce\AppBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientRegistrationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientRegistrationBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $resource = $this->manager->initResource();
        $resource->setShop($this->manager->getShopContext()->getCurrentShop());

        $form = $this->manager->getForm($resource, [
            'name'              => 'register',
            'validation_groups' => ['client_registration']
        ]);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->createResource($resource);

                $this->manager->getFlashHelper()->addSuccess('client.flash.registration.success');

                return $this->getRouterHelper()->redirectTo('front.client.login');
            }

            $this->manager->getFlashHelper()->addError('client.flash.registration.error');
        }

        return $this->displayTemplate('index', [
            'form' => $form,
        ]);
    }
}
