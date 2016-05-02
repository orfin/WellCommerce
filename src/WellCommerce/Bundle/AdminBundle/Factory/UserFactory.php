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

namespace WellCommerce\Bundle\AdminBundle\Factory;

use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class UserFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = UserInterface::class;
    
    /**
     * @return UserInterface
     */
    public function create() : UserInterface
    {
        /** @var $user UserInterface */
        $user = $this->init();
        $user->setFirstName('');
        $user->setLastName('');
        $user->setEmail('');
        $user->setEnabled(true);
        $user->setRoles($this->createEmptyCollection());
        $user->setGroups($this->createEmptyCollection());
        $user->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $user->setApiKey('');
        $user->setCreatedAt(new \DateTime());
        
        return $user;
    }
}
