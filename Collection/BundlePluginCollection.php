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

namespace WellCommerce\Bundle\DistributionBundle\Collection;

use WellCommerce\Bundle\DistributionBundle\Plugin\BundlePluginInterface;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class BundlePluginCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BundlePluginCollection extends ArrayCollection
{
    /**
     * @param BundlePluginInterface $bundlePlugin
     */
    public function add(BundlePluginInterface $bundlePlugin)
    {
        $this->items[$bundlePlugin->getName()] = $bundlePlugin;
    }

    /**
     * @return BundlePluginInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
