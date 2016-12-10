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

namespace WellCommerce\Bundle\CoreBundle\Test\Entity;

use PhpUnitEntityTester\AccessorTester;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractEntityTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEntityTestCase extends AbstractTestCase
{
    /**
     * @dataProvider providerTestAccessor
     */
    public function testAccessor($attribute, $setValue, $getValue = AccessorTester::USE_SET_DATA)
    {
        $entity = $this->createEntity();
        $tester = new AccessorTester($entity, $attribute);
        $tester->fluent(false);
        
        $tester->test($setValue, $getValue);
    }
    
    abstract protected function createEntity();
}
