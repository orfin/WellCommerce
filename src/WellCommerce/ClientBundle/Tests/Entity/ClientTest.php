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

namespace WellCommerce\ClientBundle\Tests\Entity;

use WellCommerce\ClientBundle\Entity\Client;
use WellCommerce\CoreBundle\Test\Entity\AbstractEntityTestCase;

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
        $errors = $this->validator->validate($entity, null, ['client_registration']);
        $this->assertFalse(0 === count($errors));
    }
}
