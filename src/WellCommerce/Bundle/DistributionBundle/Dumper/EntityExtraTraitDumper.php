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

namespace WellCommerce\Bundle\DistributionBundle\Dumper;

use Symfony\Component\Filesystem\Filesystem;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\EntityExtraTraitDefinition;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use WellCommerce\Bundle\DistributionBundle\Generator\EntityExtraTraitGeneratorInterface;

/**
 * Class EntityExtraTraitDumper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityExtraTraitDumper implements EntityExtraTraitDumperInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var EntityExtraTraitGeneratorInterface
     */
    protected $generator;

    /**
     * EntityExtraTraitDumper constructor.
     *
     * @param EntityExtraTraitGeneratorInterface $generator
     */
    public function __construct(EntityExtraTraitGeneratorInterface $generator)
    {
        $this->filesystem = new Filesystem();
        $this->generator  = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function dumpCollection(MappingCollection $collection)
    {
        $collection->forAll(function (MappingDefinition $definition) {
            $this->dumpDefinition($definition);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function dumpDefinition(MappingDefinition $definition)
    {
        $traitDefinition = $this->generator->generateTrait($definition);
        if ($traitDefinition instanceof EntityExtraTraitDefinition) {
            $this->filesystem->dumpFile($traitDefinition->getReflectionClass()->getFileName(), $traitDefinition->getSource());
        }
    }
}
