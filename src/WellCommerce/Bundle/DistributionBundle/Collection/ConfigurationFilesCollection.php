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

use Symfony\Component\Finder\SplFileInfo;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class ConfigurationFilesCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ConfigurationFilesCollection extends ArrayCollection
{
    public function add(SplFileInfo $fileInfo)
    {
        $this->items[] = $fileInfo;
    }
}
