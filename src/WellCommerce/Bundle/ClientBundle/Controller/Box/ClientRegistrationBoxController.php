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

namespace WellCommerce\Bundle\ClientBundle\Controller\Box;

use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;

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
        $form     = $this->get('client_register.form_builder.front')->createForm([
            'name' => 'register'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->manager->createResource($resource);

                $this->manager->getFlashHelper()->addSuccess('client.flash.registration.success');

                return $this->getRouterHelper()->redirectTo('front.client.login');
            }

            if (count($form->getError())) {
                $this->manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->displayTemplate('index', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }
}
