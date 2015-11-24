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

namespace WellCommerce\AppBundle\Tests\Entity;

use WellCommerce\AppBundle\Entity\Deliverer;
use WellCommerce\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class DelivererTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererTest extends AbstractEntityTestCase
{
    public function testNewEntityPassesValidation()
    {
        $entity = new Deliverer();
        $entity->translate('en')->setName('Test');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(0, count($errors));
    }

    public function testEntityRequiresNonEmptyName()
    {
        $entity = new Deliverer();
        $entity->translate('en')->setName('');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(1, count($errors));
    }
}
