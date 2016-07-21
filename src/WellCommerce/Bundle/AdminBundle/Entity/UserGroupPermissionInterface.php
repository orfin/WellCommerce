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

namespace WellCommerce\Bundle\AdminBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Class UserGroupPermission
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserGroupPermissionInterface extends EntityInterface, EnableableInterface
{
    /**
     * @return UserGroupInterface
     */
    public function getGroup() : UserGroupInterface;
    
    /**
     * @param UserGroupInterface $group
     */
    public function setGroup(UserGroupInterface $group);
    
    /**
     * @return int
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
}
