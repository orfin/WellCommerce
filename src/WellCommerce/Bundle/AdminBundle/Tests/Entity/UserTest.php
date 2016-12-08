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

use WellCommerce\Bundle\AdminBundle\Entity\User;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class UserTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new User();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['firstName', 'John'],
            ['lastName', 'Doe'],
            ['username', 'johndoe@domain.org'],
            ['apiKey', Helper::generateUUIDv5()],
        ];
    }
}