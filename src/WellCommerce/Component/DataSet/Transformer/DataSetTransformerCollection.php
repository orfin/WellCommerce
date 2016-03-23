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
use WellCommerce\Component\DataSet\Exception\DataSetTransformerNotFoundException;

/**
 * Class TransformerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetTransformerCollection extends ArrayCollection
{
    /**
     * @param string                      $alias
     * @param DataSetTransformerInterface $transformer
     */
    public function add($alias, DataSetTransformerInterface $transformer)
    {
        $this->items[$alias] = $transformer;
    }

    /**
     * Returns a dataset's transformer by its alias
     *
     * @param string $alias
     *
     * @return DataSetTransformerInterface
     * @throws DataSetTransformerNotFoundException
     */
    public function get($alias)
    {
        if (false === $this->has($alias)) {
            throw new DataSetTransformerNotFoundException($alias);
        }

        return $this->items[$alias];
    }
}
