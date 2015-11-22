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

/**
 * Class EqualsTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EqualsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providePassTestData
     */
    public function testEvaluatePasses($elements)
    {
        $condition = new Equals($elements[0]);

        $this->assertTrue($condition->evaluate($elements[1]));
    }

    /**
     * @dataProvider provideFailTestData
     */
    public function testEvaluateFails($elements)
    {
        $condition = new Equals($elements[0]);

        $this->assertFalse($condition->evaluate($elements[1]));
    }

    public function testGetJsNodeName()
    {
        $className = get_class(new Equals([]));
        $class     = explode('\\', $className);

        $this->assertEquals('GFormCondition.EQUALS', 'GFormCondition.' . strtoupper(end($class)));
    }

    /**
     * @return array
     */
    public function providePassTestData()
    {
        return [
            'integer' => [[1, 1]],
            'string'  => [['foo', 'foo']],
            'array'   => [[[1, 2, 3], 1]],
        ];
    }

    /**
     * @return array
     */
    public function provideFailTestData()
    {
        return [
            'integer' => [[1, 2]],
            'string'  => [['foo', 'bar']],
            'array'   => [[[1, 2, 3], 4]],
            'object'  => [[new Equals([]), 'bar']],
        ];
    }
}
