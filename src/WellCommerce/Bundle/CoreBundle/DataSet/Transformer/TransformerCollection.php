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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Transformer;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ConditionsCollection
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet\Conditions
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TransformerCollection extends AbstractCollection
{
    /**
     * Adds new field transformer to collection
     *
     * @param string               $field
     * @param TransformerInterface $transformer
     */
    public function add($field, TransformerInterface $transformer)
    {
        if ($this->has($field)) {
            throw new \LogicException(sprintf('Only one field transformer for field "" is allowed.', $field));
        }
        $this->items[$field] = $transformer;
    }
}