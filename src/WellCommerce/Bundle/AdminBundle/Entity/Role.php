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
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Role
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Role extends AbstractEntity implements RoleInterface
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string|null
     */
    protected $role;
    
    /**
     * @var Collection
     */
    protected $users;
    
    /**
     * {@inheritdoc}
     */
    public function getRole() : string
    {
        return $this->role;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRole(string $role)
    {
        $this->role = $role;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUsers(Collection $users)
    {
        $this->users = $users;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUsers() : Collection
    {
        return $this->users;
    }
}
