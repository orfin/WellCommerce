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

use WellCommerce\Bundle\AdminBundle\Entity\AdminMenu;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class AdminMenuTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new AdminMenu();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['identifier', 'sales', 'sales'],
            ['name', 'Sales'],
            ['routeName', 'admin.order.index'],
            ['cssClass', 'sales'],
            ['parent', null],
            ['hierarchy', 10],
        ];
    }
}