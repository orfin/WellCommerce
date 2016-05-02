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
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class UserGroup
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroup extends AbstractEntity implements UserGroupInterface
{
    use Blameable;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var Collection
     */
    protected $users;
    
    /**
     * @var Collection
     */
    protected $permissions;
    
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
    public function getUsers() : Collection
    {
        return $this->users;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPermissions() : Collection
    {
        return $this->permissions;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPermissions(Collection $permissions)
    {
        $this->permissions = $permissions;
    }
}
