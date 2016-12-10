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

use Carbon\Carbon;
use WellCommerce\Bundle\ContactBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ContactTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Contact();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['createdAt', Carbon::now()],
            ['updatedAt', Carbon::now()],
        ];
    }
}
