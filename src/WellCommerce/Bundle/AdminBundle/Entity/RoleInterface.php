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

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\Role\RoleInterface as BaseRoleInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface RoleInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RoleInterface extends BaseRoleInterface, EntityInterface
{
    /**
     * @param string $role
     */
    public function setRole(string $role);
    
    /**
     * @return string
     */
    public function getName() : string;
    
    /**
     * @param string $name
     */
    public function setName(string $name);
    
    /**
     * @param Collection $users
     */
    public function setUsers(Collection $users);
    
    /**
     * @return Collection
     */
    public function getUsers() : Collection;
}
