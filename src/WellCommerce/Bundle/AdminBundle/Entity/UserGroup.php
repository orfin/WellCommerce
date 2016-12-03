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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class UserGroup
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroup implements UserGroupInterface
{
    use IdentifiableTrait;
    use Blameable;
    
    protected $name = '';
    
    /**
     * @var Collection
     */
    protected $users;
    
    /**
     * @var Collection
     */
    protected $permissions;
    
    public function __construct()
    {
        $this->users       = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
    
    public function setPermissions(Collection $permissions)
    {
        $this->permissions = $permissions;
    }
}
