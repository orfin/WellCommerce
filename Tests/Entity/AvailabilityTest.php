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

namespace WellCommerce\Bundle\AppBundle\Tests\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Availability;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class AvailabilityTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityTest extends AbstractEntityTestCase
{
    public function testNewEntityPassesValidation()
    {
        $entity = new Availability();
        $entity->translate('en')->setName('Test');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(0, count($errors));
    }

    public function testEntityRequiresNonEmptyName()
    {
        $entity = new Availability();
        $entity->translate('en')->setName('');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(1, count($errors));
    }
}
