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

use WellCommerce\Bundle\AdminBundle\Entity\UserGroup;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;

/**
 * Class UserGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupFactory extends AbstractEntityFactory
{
    public function create() : UserGroupInterface
    {
        $group = new UserGroup();
        $group->setName('');
        $group->setPermissions($this->createEmptyCollection());
        
        return $group;
    }
}
