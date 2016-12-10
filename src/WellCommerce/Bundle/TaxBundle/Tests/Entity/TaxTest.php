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

namespace WellCommerce\Bundle\TaxBundle\Tests\Entity;

use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;

/**
 * Class TaxTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Tax();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['value', 0.00],
            ['value', 17.99],
            ['value', 22.49],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ];
    }
}
