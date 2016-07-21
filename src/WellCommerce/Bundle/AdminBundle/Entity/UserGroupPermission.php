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

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableTrait;

/**
 * Class UserGroupPermission
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupPermission implements UserGroupPermissionInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use EnableableTrait;
    
    /**
     * @var UserGroupInterface
     */
    protected $group;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * {@inheritdoc}
     */
    public function getGroup() : UserGroupInterface
    {
        return $this->group;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setGroup(UserGroupInterface $group)
    {
        $this->group = $group;
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
}
