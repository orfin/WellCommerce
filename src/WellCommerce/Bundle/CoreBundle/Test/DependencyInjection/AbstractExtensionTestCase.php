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

namespace WellCommerce\Bundle\CoreBundle\Test\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractExtensionTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractExtensionTestCase extends AbstractTestCase
{
    /**
     * @dataProvider getRequiredServices
     */
    public function testRequiredServices($services)
    {
        foreach ($services as $service) {
            $this->assertTrue($this->container->has($service), sprintf('Container does not have %s service', $service));
        }
    }

    public function getRequiredServices()
    {
        return [
            'services' => [[]]
        ];
    }
}
