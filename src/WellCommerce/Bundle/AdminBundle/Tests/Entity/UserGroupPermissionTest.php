<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\AdminBundle\Tests\Entity;

use WellCommerce\Bundle\AdminBundle\Entity\UserGroup;
use WellCommerce\Bundle\AdminBundle\Entity\UserGroupPermission;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class UserGroupPermissionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupPermissionTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new UserGroupPermission();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['name', 'permission_' . rand(1, 100)],
            ['group', new UserGroup()],
        ];
    }
}