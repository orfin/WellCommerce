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

use WellCommerce\Bundle\AdminBundle\Entity\RoleInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class RoleFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoleFactory extends AbstractEntityFactory
{
    protected $supportsInterface = RoleInterface::class;
    
    public function create() : RoleInterface
    {
        $role = $this->init();
        $role->setName('');
        $role->setUsers($this->createEmptyCollection());
        
        return $role;
    }
}
