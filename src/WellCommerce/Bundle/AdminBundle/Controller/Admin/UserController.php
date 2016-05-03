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

namespace WellCommerce\Bundle\AdminBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use WellCommerce\Bundle\AdminBundle\Exception\ResetPasswordException;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class UserController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserController extends AbstractAdminController
{
    public function loginAction(Request $request) : Response
    {
        $form = $this->get('user_login.form_builder')->createForm([
            'name'         => 'login',
            'ajax_enabled' => false,
            'action'       => $this->getRouterHelper()->generateUrl('admin.user.login_check'),
            'class'        => 'login-form',
        ], null);

        return $this->displayTemplate('login', [
            'error' => $this->getSecurityErrors($request),
            'form'  => $form
        ]);
    }

    public function resetPasswordAction() : Response
    {
        $form = $this->createLoginForm();

        if ($form->handleRequest()->isSubmitted()) {
            $formValues = $form->getValue();
            $username   = $formValues['username'];

            try {
                $this->manager->resetPassword($username);

            } catch (ResetPasswordException $e) {
                $this->getFlashHelper()->addError($e->getMessage());

                return $this->redirectToAction('reset_password');
            }

            $this->getFlashHelper()->addSuccess('user.flash.success.reset_password');

            return $this->redirectToAction('login');
        }

        return $this->displayTemplate('reset_password', [
            'form' => $form
        ]);
    }

    private function createLoginForm() : FormInterface
    {
        return $this->get('user_reset_password.form_builder')->createForm([
            'name'         => 'reset_password',
            'ajax_enabled' => false,
            'class'        => 'login-form',
        ], null);
    }

    private function getSecurityErrors(Request $request)
    {
        $session = $request->getSession();
        $error   = '';

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return $error;
    }

    public function loginCheckAction()
    {
    }

    public function deleteAction(int $id) : Response
    {
        $user = $this->getSecurityHelper()->getUser();
        if (null !== $user && $user->getId() === $id) {
            return $this->jsonResponse(['error' => 'You cannot delete your own admin account.']);
        }

        $em = $this->getDoctrineHelper()->getEntityManager();

        try {
            $resource = $this->manager->getRepository()->find($id);
            $em->remove($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()]);
        }

        $em->flush();

        return $this->jsonResponse(['success' => true]);
    }

    public function accessDeniedAction() : Response
    {
        return $this->displayTemplate('access_denied');
    }
}
