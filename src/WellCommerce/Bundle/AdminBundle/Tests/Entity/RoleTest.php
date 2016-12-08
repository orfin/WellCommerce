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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AdminBundle\Entity\Role;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class RoleTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoleTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Role();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['name', 'Test role'],
            ['role', 'ROLE_ADMIN'],
            ['users', new ArrayCollection()],
        ];
    }
}