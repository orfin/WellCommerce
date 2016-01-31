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

use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingFilesCollection;

/**
 * Class BaseMappingFinder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingFinder implements MappingFinderInterface
{
    /**
     * {@inheritdoc}
     */
    public function findMappingFiles($fileNamePattern, $searchPathPattern)
    {
        $finder     = new Finder();
        $collection = new MappingFilesCollection();

        foreach ($finder->in($searchPathPattern)->name($fileNamePattern) as $file) {
            $collection->add($file);
        }

        return $collection;
    }
}
