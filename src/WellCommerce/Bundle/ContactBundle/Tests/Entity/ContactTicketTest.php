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

namespace WellCommerce\Bundle\ContactBundle\Tests\Entity;

use WellCommerce\Bundle\ContactBundle\Entity\ContactTicket;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ContactTicketTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTicketTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new ContactTicket();
    }
    
    public function providerTestAccessor()
    {
        $faker = $this->getFakerGenerator();
        
        return [
            ['name', $faker->firstName],
            ['surname', $faker->lastName],
            ['subject', $faker->randomAscii],
            ['phone', $faker->phoneNumber],
            ['email', $faker->email],
            ['content', $faker->randomAscii],
            ['createdAt', $faker->dateTime],
            ['updatedAt', $faker->dateTime],
        ];
    }
}
