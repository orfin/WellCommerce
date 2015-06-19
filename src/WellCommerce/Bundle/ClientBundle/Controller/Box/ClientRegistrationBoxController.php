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

/**
 * Class ClientRegistrationBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class ClientRegistrationBoxController extends AbstractBoxController
{
    public function indexAction(Request $request)
    {
        $manager  = $this->getManager();
        $resource = $manager->initResource();
        $form     = $this->get('client_register.form_builder.front')->createForm([
            'name' => 'register'
        ], $resource);

        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $manager->createResource($resource, $request);

                $manager->getFlashHelper()->addSuccess('client.flash.registration.success');

                return $manager->getRedirectHelper()->redirectTo('front.client.login');
            }

            if (count($form->getError())) {
                $manager->getFlashHelper()->addError('client.form.error.registration');
            }
        }

        return $this->render('WellCommerceClientBundle:Box/ClientRegistration:index.html.twig', [
            'form'     => $form,
            'elements' => $form->getChildren(),
        ]);
    }
}
