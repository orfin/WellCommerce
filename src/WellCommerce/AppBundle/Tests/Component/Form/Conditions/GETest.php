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

namespace WellCommerce\AppBundle\Tests\Component\Form;

use WellCommerce\Component\Form\Conditions\Equals;
use WellCommerce\Component\Form\Conditions\GE;

/**
 * Class GETest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class GETest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providePassTestData
     */
    public function testEvaluatePasses($elements)
    {
        $condition = new GE($elements[0]);

        $this->assertTrue($condition->evaluate($elements[1]));
    }

    /**
     * @dataProvider provideFailTestData
     */
    public function testEvaluateFails($elements)
    {
        $condition = new GE($elements[0]);

        $this->assertFalse($condition->evaluate($elements[1]));
    }

    public function testGetJsNodeName()
    {
        $className = get_class(new GE([]));
        $class     = explode('\\', $className);

        $this->assertEquals('GFormCondition.GE', 'GFormCondition.' . strtoupper(end($class)));
    }

    /**
     * @return array
     */
    public function providePassTestData()
    {
        return [
            'integer_equal'   => [[1, 1]],
            'integer_greater' => [[1, 2]],
        ];
    }

    /**
     * @return array
     */
    public function provideFailTestData()
    {
        return [
            'integer' => [[1, 0]],
            'object'  => [[new Equals([]), 'bar']],
        ];
    }
}
