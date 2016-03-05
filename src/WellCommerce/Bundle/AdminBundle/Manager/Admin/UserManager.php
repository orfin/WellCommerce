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

namespace WellCommerce\Bundle\AdminBundle\Manager\Admin;

use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\AdminBundle\Exception\ResetPasswordException;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class UserManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserManager extends AbstractAdminManager
{
    public function resetPassword($username)
    {
        $user = $this->repository->findOneBy([
            'username' => $username
        ]);

        if (!$user instanceof UserInterface) {
            throw new ResetPasswordException($this->getTranslatorHelper()->trans('user.flash.error.wrong_username'));
        }

        if (false === $user->getEnabled()) {
            throw new ResetPasswordException($this->getTranslatorHelper()->trans('user.flash.error.blocked_account'));
        }

        $password = $this->getSecurityHelper()->generateRandomPassword();
        $user->setPassword($password);
        $this->updateResource($user);

        $email      = $user->getEmail();
        $title      = $this->getTranslatorHelper()->trans('user.email.title.reset_password');
        $template   = 'WellCommerceAdminBundle:Admin/Email:reset_password.html.twig';
        $parameters = ['password' => $password];
        $shop       = $this->get('shop.context.admin')->getCurrentShop();

        $this->getMailerHelper()->sendEmail($email, $title, $template, $parameters, $shop->getMailerConfiguration());
    }
}
