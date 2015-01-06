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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

/**
 * Interface DataTransformerInterface
 *
 * @package WellCommerce\Bundle\CoreBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataTransformerInterface
{
    /**
     * Transforms a value from model
     *
     * @param $value
     *
     * @return mixed
     */
    public function transform($value);

    /**
     * Transforms submitted values to model representation
     *
     * @param $value
     * @param $data
     */
    public function reverseTransform($value, $data);

} 