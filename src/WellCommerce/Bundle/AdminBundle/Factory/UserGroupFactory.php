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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class UserGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = UserGroupInterface::class;
    
    /**
     * @return UserGroupInterface
     */
    public function create() : UserGroupInterface
    {
        /** @var $group UserGroupInterface */
        $group = $this->init();
        $group->setName('');
        $group->setPermissions(new ArrayCollection());
        
        return $group;
    }
}
