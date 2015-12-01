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

use WellCommerce\Bundle\AppBundle\Entity\Contact;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ContactTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTest extends AbstractEntityTestCase
{
    public function testNewEntityPassesValidation()
    {
        $entity = new Contact();
        $entity->setEnabled(true);
        $entity->translate('en')->setName('Test');
        $entity->translate('en')->setEmail('test@test.com');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(0, count($errors));
    }

    public function testValidationFailsIfEmptyNameAndEmail()
    {
        $entity = new Contact();
        $entity->setEnabled(true);
        $entity->translate('en')->setName('');
        $entity->translate('en')->setEmail('');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(2, count($errors));
    }

    public function testValidationPassesIfEnabledIsNull()
    {
        $entity = new Contact();
        $entity->setEnabled(null);
        $entity->translate('en')->setName('Test');
        $entity->translate('en')->setEmail('test@test.com');
        $entity->mergeNewTranslations();

        $errors = $this->validator->validate($entity);
        $this->assertEquals(0, count($errors));
        $this->assertFalse($entity->getEnabled());
    }
}
