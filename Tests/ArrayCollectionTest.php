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

namespace WellCommerce\Common\Collections\Tests;

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ArrayCollectionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ArrayCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideDifferentElements
     */
    public function testAll($elements)
    {
        $collection = new ArrayCollection($elements);

        $this->assertSame($elements, $collection->all());
    }

    /**
     * @dataProvider provideDifferentElements
     */
    public function testCount($elements)
    {
        $collection = new ArrayCollection($elements);

        $this->assertEquals(count($elements), $collection->count());
    }

    /**
     * @dataProvider provideDifferentElements
     */
    public function testHas($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $this->assertArrayHasKey($key, $collection->all());
        }
    }

    /**
     * @dataProvider provideDifferentElements
     */
    public function testGet($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $this->assertSame($val, $collection->get($key));
        }
    }

    /**
     * @dataProvider provideDifferentElements
     */
    public function testRemove($elements)
    {
        $collection = new ArrayCollection($elements);

        foreach ($elements as $key => $val) {
            $collection->remove($key);
            $this->assertArrayNotHasKey($key, $collection->all());
        }
    }

    /**
     * @dataProvider provideDifferentElements
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
    public function provideDifferentElements()
    {
        return [
            'indexed'     => [[1, 2, 3, 4, 5]],
            'associative' => [['A' => 'a', 'B' => 'b', 'C' => 'c']],
            'mixed'       => [['A' => 'a', 1, 'B' => 'b', 2, 3]],
        ];
    }
}
