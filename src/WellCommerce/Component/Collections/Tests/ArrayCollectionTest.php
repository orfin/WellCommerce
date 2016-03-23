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

namespace WellCommerce\Component\Collections\Tests;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class ArrayCollectionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ArrayCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testAll($elements)
    {
        $collection = new ArrayCollection($elements);

        $this->assertSame($elements, $collection->all());
    }

    /**
     * @dataProvider provideTestData
     */
    public function testCount($elements)
    {
        $collection = new ArrayCollection($elements);

        $this->assertEquals(count($elements), $collection->count());
    }

    /**
     * @dataProvider provideTestData
     */
    public function testHas($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $this->assertTrue($collection->has($key));
        }
    }

    /**
     * @dataProvider provideTestData
     */
    public function testGet($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $this->assertSame($val, $collection->get($key));
        }
    }

    /**
     * @dataProvider provideTestData
     */
    public function testRemove($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $collection->remove($key);
            $this->assertArrayNotHasKey($key, $collection->all());
            $this->assertFalse($collection->has($key));
        }
    }

    /**
     * @dataProvider provideTestData
     */
    public function testGetIterator($elements)
    {
        $collection = new ArrayCollection($elements);

        $iterations = 0;
        foreach ($collection->getIterator() as $key => $item) {
            $this->assertSame($elements[$key], $item);
            $iterations++;
        }

        $this->assertEquals(count($elements), $iterations);
    }

    /**
     * @return array
     */
    public function provideTestData()
    {
        return [
            'indexed'     => [[1, 2, 3, 4, 5]],
            'associative' => [['A' => 'a', 'B' => 'b', 'C' => 'c']],
            'mixed'       => [['A' => 'a', 1, 'B' => 'b', 2, 3]],
        ];
    }
}
