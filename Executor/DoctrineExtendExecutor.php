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

namespace WellCommerce\Bundle\DistributionBundle\Executor;

use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use WellCommerce\Bundle\DistributionBundle\Dumper\EntityExtraTraitDumperInterface;
use WellCommerce\Bundle\DistributionBundle\Dumper\MappingDumperInterface;
use WellCommerce\Bundle\DistributionBundle\Factory\MappingCollectionFactory;
use WellCommerce\Bundle\DistributionBundle\Finder\MappingFinderInterface;
use WellCommerce\Bundle\DistributionBundle\Manipulator\MappingConfigurationManipulatorInterface;
use WellCommerce\Bundle\DistributionBundle\Merger\MappingMergerInterface;

/**
 * Class DoctrineExtendExecutor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DoctrineExtendExecutor
{
    /**
     * @var MappingFinderInterface
     */
    protected $mappingFinder;

    /**
     * @var MappingMergerInterface
     */
    protected $mappingMerger;

    /**
     * @var MappingDumperInterface
     */
    protected $mappingDumper;

    /**
     * @var EntityExtraTraitDumperInterface
     */
    protected $traitDumper;

    /**
     * @var MappingConfigurationManipulatorInterface
     */
    protected $mappingConfigurationManipulator;

    /**
     * DoctrineExtendExecutor constructor.
     *
     * @param MappingFinderInterface                   $finder
     * @param MappingMergerInterface                   $merger
     * @param MappingDumperInterface                   $dumper
     * @param EntityExtraTraitDumperInterface          $traitDumper
     * @param MappingConfigurationManipulatorInterface $mappingConfigurationManipulator
     */
    public function __construct(
        MappingFinderInterface $finder,
        MappingMergerInterface $merger,
        MappingDumperInterface $dumper,
        EntityExtraTraitDumperInterface $traitDumper,
        MappingConfigurationManipulatorInterface $mappingConfigurationManipulator
    ) {
        $this->mappingFinder                   = $finder;
        $this->mappingMerger                   = $merger;
        $this->mappingDumper                   = $dumper;
        $this->traitDumper                     = $traitDumper;
        $this->mappingConfigurationManipulator = $mappingConfigurationManipulator;
    }

    /**
     * @return MappingCollection
     */
    public function execute()
    {
        $extraMappingCollection = $this->getMappingCollection('extra.orm.yml', 'src/*/Bundle/*/Resources/config');
        $baseMappingCollection  = $this->getMappingCollection('*.orm.yml', 'src/*/Bundle/*/Resources/config/doctrine');

        if ($extraMappingCollection->count()) {
            $this->traitDumper->dumpCollection($extraMappingCollection);
            $mappingCollection = $this->mergeMappings($extraMappingCollection, $baseMappingCollection);
            $this->mappingDumper->dumpCollection($mappingCollection);
            $this->mappingConfigurationManipulator->modifyMappedServices($mappingCollection, $this->mappingDumper->getTargetPath());
        }

        return $extraMappingCollection;
    }

    /**
     * Merges base mappings into extra mapping definition
     *
     * @param MappingCollection $extraMappingCollection
     * @param MappingCollection $baseMappingCollection
     *
     * @return MappingCollection
     */
    protected function mergeMappings(MappingCollection $extraMappingCollection, MappingCollection $baseMappingCollection)
    {
        $extraMappingCollection->forAll(function (MappingDefinition $definition) use ($baseMappingCollection) {
            if ($baseMappingCollection->has($definition->getClassName())) {
                $this->mappingMerger->merge($definition, $baseMappingCollection->get($definition->getClassName()));
            }
        });

        return $extraMappingCollection;
    }

    /**
     * Returns the mapping collection generated from files
     *
     * @return \WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection
     */
    protected function getMappingCollection($fileNamePattern, $searchPathPattern)
    {
        $mappingCollectionFactory = new MappingCollectionFactory();
        $filesCollection          = $this->mappingFinder->findMappingFiles($fileNamePattern, $searchPathPattern);

        return $mappingCollectionFactory->createFromFiles($filesCollection);
    }
}
