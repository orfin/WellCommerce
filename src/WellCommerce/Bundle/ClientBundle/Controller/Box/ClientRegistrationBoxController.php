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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\CoreBundle\Controller\Box\BoxControllerInterface;

/**
 * Class ClientRegistrationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ClientRegistrationBoxController extends AbstractBoxController implements BoxControllerInterface
{
    public function indexAction(Request $request)
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
