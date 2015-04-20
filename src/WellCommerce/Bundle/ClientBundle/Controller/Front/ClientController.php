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

namespace WellCommerce\Bundle\ClientBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ClientController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ClientController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
    }

    public function loginAction()
    {
        $form = $this->get('client_login.form_builder.front')->createForm([
            'name'         => 'login',
            'ajax_enabled' => false,
            'action'       => $this->generateUrl('front.client.login_check')
        ], null);

        return [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ];

    }

    public function registerAction(Request $request)
    {
        $resource = $this->getManager()->initResource();
        $form     = $this->get('client_register.form_builder.front')->createForm([
            'name' => 'register'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->createResource($resource, $request);

                $this->getManager()->getFlashHelper()->addSuccess('client.flash.registration.success');

                return $this->getManager()->getRedirectHelper()->redirectToAction('register');
            }

            if (count($form->getError())) {
                $this->getManager()->getFlashHelper()->addError('client.flash.registration.error');
            }
        }

        return [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ];
    }
}
