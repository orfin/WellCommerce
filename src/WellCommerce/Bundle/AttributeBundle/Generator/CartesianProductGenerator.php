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

namespace WellCommerce\Bundle\AttributeBundle\Generator;

/**
 * Class CartesianProductGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartesianProductGenerator
{
    /**
     * Generates a cartesian product from input values
     *
     * @param array $input
     *
     * @return array
     */
    public static function generateCartesianProduct(array $input) : array
    {
        $result = [];

        while (list($key, $values) = each($input)) {
            if (empty($values)) {
                continue;
            }

            if (empty($result)) {
                foreach ($values as $value) {
                    $result[] = [$key => $value];
                }
            } else {
                $append = [];

                foreach ($result as &$product) {
                    $product[$key] = array_shift($values);
                    $copy          = $product;

                    foreach ($values as $item) {
                        $copy[$key] = $item;
                        $append[]   = $copy;
                    }

                    array_unshift($values, $product[$key]);
                }

                $result = array_merge($result, $append);
            }
        }

        return $result;
    }
}
