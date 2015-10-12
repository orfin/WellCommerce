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

use WellCommerce\Common\Collections\ArrayCollection;

/**
 * Class ProviderCollection
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ResourceProviderCollection extends ArrayCollection
{
    /**
     * Adds new resource provider to collection
     *
     * @param string                    $type
     * @param ResourceProviderInterface $resourceProvider
     */
    public function add($type, ResourceProviderInterface $resourceProvider)
    {
        $this->items[$type] = $resourceProvider;
    }
}
