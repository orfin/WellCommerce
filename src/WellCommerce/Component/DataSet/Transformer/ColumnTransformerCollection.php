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

use WellCommerce\Component\Collections\ArrayCollection;
use WellCommerce\Component\DataSet\Exception\TransformerInvalidColumnException;

/**
 * Class ColumnTransformerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnTransformerCollection extends ArrayCollection
{
    /**
     * Adds new field transformer to collection
     *
     * @param string                      $field
     * @param DataSetTransformerInterface $transformer
     */
    public function add($field, DataSetTransformerInterface $transformer)
    {
        if ($this->has($field)) {
            throw new TransformerInvalidColumnException($field);
        }

        $this->items[$field] = $transformer;
    }
}
