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
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Class MappingDumper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingDumper implements MappingDumperInterface
{
    /**
     * @var string
     */
    protected $targetPath;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * MappingDumper constructor.
     *
     * @param string $targetPath
     */
    public function __construct($targetPath)
    {
        $this->targetPath = $targetPath;
        $this->filesystem = new Filesystem();
        $this->checkTargetDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetPath()
    {
        return $this->targetPath;
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
        $filename   = sprintf(MappingDumperInterface::FILENAME_PATTERN, $definition->getReflectionClass()->getShortName());
        $targetPath = $this->targetPath . '/' . $filename;
        $content    = $this->dumpContent([$definition->getClassName() => $definition->getMapping()]);

        $this->filesystem->dumpFile($targetPath, $content);
    }

    private function checkTargetDir()
    {
        if (false === $this->filesystem->exists($this->targetPath)) {
            $this->filesystem->mkdir($this->targetPath, 0755);
        }
    }

    /**
     * Converts an array of mappings into Yaml structure
     *
     * @param array $mappings
     *
     * @return string
     */
    protected function dumpContent(array $mappings)
    {
        return Yaml::dump($mappings, 6);
    }
}
