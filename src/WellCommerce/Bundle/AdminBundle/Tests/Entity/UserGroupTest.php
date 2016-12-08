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
use WellCommerce\Bundle\AdminBundle\Entity\UserGroup;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class UserGroupTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new UserGroup();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['name', 'Administrators'],
            ['users', new ArrayCollection()],
            ['permissions', new ArrayCollection()],
        ];
    }
}