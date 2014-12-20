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
interface DataTransformerInterface {

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param $value
     *
     * @return mixed
     */
    public function transform($value);

    /**
     * Transforms a value from the transformed representation to its original
     * representation.
     *
     * @param $value
     *
     * @return object
     */
    public function reverseTransform($value);

} 