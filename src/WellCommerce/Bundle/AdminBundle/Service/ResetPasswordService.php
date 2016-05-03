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

namespace WellCommerce\Bundle\AdminBundle\Service;

use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\AdminBundle\Exception\ResetPasswordException;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Mailer\MailerHelperInterface;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;

/**
 * Class ResetPasswordService
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ResetPasswordService implements ResetPasswordServiceInterface
{
    /**
     * @var ManagerInterface
     */
    private $manager;
    
    /**
     * @var MailerHelperInterface
     */
    private $mailerHelper;
    
    /**
     * ResetPasswordService constructor.
     *
     * @param ManagerInterface      $manager
     * @param MailerHelperInterface $mailerHelper
     */
    public function __construct(ManagerInterface $manager, MailerHelperInterface $mailerHelper)
    {
        $this->manager      = $manager;
        $this->mailerHelper = $mailerHelper;
    }
    
    public function resetPassword(string $username)
    {
        $user = $this->manager->getRepository()->findOneBy([
            'username' => $username
        ]);
        
        if (!$user instanceof UserInterface) {
            throw new ResetPasswordException('user.flash.error.wrong_username');
        }
        
        if (false === $user->getEnabled()) {
            throw new ResetPasswordException('user.flash.error.blocked_account');
        }
        
        $password = Helper::generateRandomPassword();
        $user->setPassword($password);
        $this->manager->updateResource($user);
        
        $this->mailerHelper->sendEmail([
            'recipient'     => $user->getEmail(),
            'subject'       => 'user.email.title.reset_password',
            'template'      => 'WellCommerceAdminBundle:Admin/Email:reset_password.html.twig',
            'parameters'    => [
                'user'     => $user,
                'password' => $password
            ],
            'configuration' => $this->get('shop.context.admin')->getCurrentShop()->getMailerConfiguration(),
        ]);
    }
}
