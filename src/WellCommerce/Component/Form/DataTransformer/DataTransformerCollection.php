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

namespace WellCommerce\Component\Form\DataTransformer;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class DataTransformerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataTransformerCollection extends ArrayCollection
{
    /**
     * Adds new transformer
     *
     * @param string $alias
     * @param string $transformer $serviceId
     */
    public function add($alias, $serviceId)
    {
        $this->items[$alias] = $serviceId;
    }
}
