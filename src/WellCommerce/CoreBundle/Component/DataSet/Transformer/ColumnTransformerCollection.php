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

namespace WellCommerce\CoreBundle\Component\DataSet\Transformer;

use Doctrine\Common\Util\Debug;
use WellCommerce\CoreBundle\Component\DataSet\Exception\TransformerInvalidColumnException;
use WellCommerce\CoreBundle\Component\Collection\ArrayCollection;

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
