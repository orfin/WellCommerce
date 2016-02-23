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

namespace WellCommerce\Component\DataSet\Transformer;

/**
 * Interface TransformerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetTransformerInterface
{
    /**
     * Transforms the row's value
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function transformValue($value);

    /**
     * Configures the context
     *
     * @param array $options
     */
    public function configure(array $options = []);
}
