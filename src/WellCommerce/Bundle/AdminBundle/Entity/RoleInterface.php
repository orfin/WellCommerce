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

/**
 * Interface RoleInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RoleInterface extends BaseRoleInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string|null $role
     */
    public function setRole($role);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param Collection $users
     */
    public function setUsers(Collection $users);

    /**
     * @return Collection
     */
    public function getUsers();
}
