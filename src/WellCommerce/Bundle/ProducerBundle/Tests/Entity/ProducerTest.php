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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Entity;

use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\ProducerBundle\Entity\Producer;

/**
 * Class ProducerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerTest extends AbstractEntityTestCase
{
    public function testNewEntityPassesValidation()
    {
        $entity = new Producer();
        $entity->translate('en')->setName('Test');
        $entity->translate('en')->setSlug('test');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(0, count($errors));
    }

    public function testEntityRequiresNonEmptyNameAndSlug()
    {
        $entity = new Producer();
        $entity->translate('en')->setName('');
        $entity->translate('en')->setSlug('');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(2, count($errors));
    }
}
