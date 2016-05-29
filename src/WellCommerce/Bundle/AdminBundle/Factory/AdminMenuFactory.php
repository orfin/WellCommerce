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

use WellCommerce\Bundle\AdminBundle\Entity\AdminMenuInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;

/**
 * Class AdminMenuFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuFactory extends EntityFactory
{
    public function create() : AdminMenuInterface
    {
        $adminMenu = $this->init();
        $adminMenu->setParent(null);
        $adminMenu->setCssClass('');
        $adminMenu->setChildren($this->createEmptyCollection());
        
        return $adminMenu;
    }
}
