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

namespace WellCommerce\Bundle\CoreBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ProviderCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProviderCollection extends AbstractCollection
{
    /**
     * Adds new provider to collection
     *
     * @param string            $type
     * @param ProviderInterface $provider
     */
    public function add($type, ProviderInterface $provider)
    {
        $this->items[$type] = $provider;
    }
}