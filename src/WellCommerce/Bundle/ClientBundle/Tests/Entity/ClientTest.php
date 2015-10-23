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

namespace WellCommerce\Bundle\ClientBundle\Tests\Entity;

use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;

/**
 * Class ClientTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientTest extends AbstractEntityTestCase
{
    public function testNewEntityFailsValidation()
    {
        $entity = new Client();
        $errors = $this->validator->validate($entity, null, ['registration']);
        $this->assertFalse(0 === count($errors));
    }

    public function testNewEntityPassesValidation()
    {
        $entity = $this->container->get('client.factory')->create();
        $entity->setConditionsAccepted(true);
        $entity->setDiscount(0);
        $entity->getContactDetails()->setEmail('foo@bar.com');
        $entity->getBillingAddress()->setFirstName('John');
        $entity->getBillingAddress()->setLastName('Doe');
        $entity->getContactDetails()->setPhone('555666777');
        $entity->setUsername('foo@bar.com');
        $entity->setPassword('password');
        $errors = $this->validator->validate($entity, null, ['registration']);
        $this->assertEquals(0, count($errors));
    }
}
