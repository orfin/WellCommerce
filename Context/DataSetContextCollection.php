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

namespace WellCommerce\Component\DataSet\Context;

use WellCommerce\Component\Collections\ArrayCollection;
use WellCommerce\Component\DataSet\Exception\DataSetContextNotFoundException;

/**
 * Class DataSetContextCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetContextCollection extends ArrayCollection
{
    public function add($alias, DataSetContextInterface $context)
    {
        $this->items[$alias] = $context;
    }

    /**
     * Returns a dataset's context by its alias
     *
     * @param string $alias
     *
     * @return DataSetContextInterface
     * @throws DataSetContextNotFoundException
     */
    public function get($alias)
    {
        if (false === $this->has($alias)) {
            throw new DataSetContextNotFoundException($alias);
        }

        return $this->items[$alias];
    }
}
