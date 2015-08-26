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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\Entity;

use WellCommerce\Bundle\AvailabilityBundle\Entity\Availability;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class AvailabilityTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityTest extends AbstractEntityTestCase
{
    public function testEntityCanBeValidated()
    {
        $availability = new Availability();
        $availability->translate('en')->setName('Test');
        $availability->mergeNewTranslations();

        $errors = $this->validator->validate($availability);
        $this->assertEquals(0, count($errors));
    }
}
