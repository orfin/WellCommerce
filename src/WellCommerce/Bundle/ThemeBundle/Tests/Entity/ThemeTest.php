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

namespace WellCommerce\Bundle\ThemeBundle\Tests\Entity;

use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\ThemeBundle\Entity\Theme;

/**
 * Class ThemeTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Theme();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['name', 'WellCommerce Default Theme'],
            ['folder', 'wellcommerce-default-theme'],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ];
    }
}
