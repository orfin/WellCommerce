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

namespace WellCommerce\CoreBundle\Component\Form\DataTransformer;

use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Interface DataTransformerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataTransformerInterface
{
    /**
     * Transforms model data into its element representation
     *
     * @param object $modelData
     *
     * @return mixed
     */
    public function transform($modelData);

    /**
     * Transforms element value into its model representation
     *
     * @param object                $modelData
     * @param PropertyPathInterface $propertyPath
     * @param mixed                 $value
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value);
}
