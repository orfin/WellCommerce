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
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Mailer\MailerHelperInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorageInterface;

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
     * @var ShopStorageInterface
     */
    private $shopStorage;
    
    /**
     * ResetPasswordService constructor.
     *
     * @param ManagerInterface      $manager
     * @param MailerHelperInterface $mailerHelper
     * @param ShopStorageInterface  $shopStorage
     */
    public function __construct(ManagerInterface $manager, MailerHelperInterface $mailerHelper, ShopStorageInterface $shopStorage)
    {
        $this->manager      = $manager;
        $this->mailerHelper = $mailerHelper;
        $this->shopStorage  = $shopStorage;
    }
    
    public function resetPasswordForUser(UserInterface $user)
    {
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
            'configuration' => $this->shopStorage->getCurrentShop()->getMailerConfiguration(),
        ]);
    }
}
