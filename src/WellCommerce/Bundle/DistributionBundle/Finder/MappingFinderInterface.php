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

namespace WellCommerce\Bundle\DistributionBundle\Finder;

/**
 * Interface MappingFinderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingFinderInterface
{
    /**
     * Returns a collection of mapping files found in given path pattern
     *
     * @param string $fileNamePattern
     * @param string $searchPathPattern
     *
     * @return \WellCommerce\Bundle\DistributionBundle\Collection\MappingFilesCollection
     */
    public function findMappingFiles($fileNamePattern, $searchPathPattern);
}
