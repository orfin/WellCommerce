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

namespace WellCommerce\Bundle\CompanyBundle\Tests\Entity;

use WellCommerce\Bundle\CompanyBundle\Entity\CompanyAddress;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class CompanyAddressTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyAddressTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new CompanyAddress();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['line1', $faker->address],
            ['line2', $faker->address],
            ['postalCode', $faker->postcode],
            ['state', $faker->citySuffix],
            ['country', $faker->country],
            ['city', $faker->city],
        ];
    }
}
