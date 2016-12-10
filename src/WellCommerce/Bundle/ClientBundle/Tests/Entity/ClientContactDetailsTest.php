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

use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetails;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ClientContactDetailsTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientContactDetailsTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new ClientContactDetails();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['firstName', $faker->firstName],
            ['lastName', $faker->lastName],
            ['phone', $faker->phoneNumber],
            ['secondaryPhone', $faker->phoneNumber],
            ['email', $faker->email],
        ];
    }
}
