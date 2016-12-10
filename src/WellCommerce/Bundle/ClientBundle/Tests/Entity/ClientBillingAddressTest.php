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

namespace WellCommerce\Bundle\ClientBundle\Tests\Entity;

use WellCommerce\Bundle\ClientBundle\Entity\ClientBillingAddress;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ClientBillingAddressTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientBillingAddressTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new ClientBillingAddress();
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
            ['firstName', $faker->firstName],
            ['lastName', $faker->lastName],
            ['vatId', $faker->randomDigit],
            ['companyName', $faker->company],
        ];
    }
}
