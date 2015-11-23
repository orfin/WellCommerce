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

namespace WellCommerce\AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use WellCommerce\AppBundle\Controller\Admin\AbstractAdminController;

/**
 * Class UserController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserController extends AbstractAdminController
{
    public function loginAction(Request $request)
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

    /**
     * Returns security errors
     *
     * @param Request $request
     *
     * @return mixed|string
     */
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

    public function loginCheckAction(Request $request)
    {
    }

    public function deleteAction($id)
    {
        $user = $this->getUser();
        if (null !== $user && $user->getId() === $id) {
            return $this->jsonResponse(['error' => 'You cannot delete your own admin account.']);
        }

        $em = $this->manager->getDoctrineHelper()->getEntityManager();

        try {
            $resource = $this->manager->getRepository()->find($id);
            $em->remove($resource);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()]);
        }

        $em->flush();

        return $this->jsonResponse(['success' => true]);
    }

    public function accessDeniedAction()
    {
        return $this->displayTemplate('access_denied');
    }
}
