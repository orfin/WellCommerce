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

namespace WellCommerce\Bundle\DistributionBundle\Factory;

use Symfony\Component\Finder\SplFileInfo;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingFilesCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use WellCommerce\Bundle\DistributionBundle\Parser\MappingParser;

/**
 * Class MappingCollectionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingCollectionFactory
{
    /**
     * Creates a collection of mappings from given files collection
     *
     * @param MappingFilesCollection $mappingFilesCollection
     *
     * @return MappingCollection
     */
    public function createFromFiles(MappingFilesCollection $mappingFilesCollection)
    {
        $collection = new MappingCollection();
        $parser     = new MappingParser();

        $mappingFilesCollection->forAll(function (SplFileInfo $fileInfo) use ($collection, $parser) {
            $mappings = $parser->parseFile($fileInfo);
            if (!empty($mappings)) {
                $this->addMappingsToCollection($mappings, $collection);
            }
        });

        return $collection;
    }

    /**
     * Adds or updates mappings in collection
     *
     * @param array             $mappings
     * @param MappingCollection $collection
     */
    protected function addMappingsToCollection(array $mappings, MappingCollection $collection)
    {
        foreach ($mappings as $className => $mapping) {
            if ($collection->has($className)) {
                $collection->update($className, $mapping);
            } else {
                $definition = new MappingDefinition($className, $mapping);
                $collection->add($definition);
            }
        }
    }
}
