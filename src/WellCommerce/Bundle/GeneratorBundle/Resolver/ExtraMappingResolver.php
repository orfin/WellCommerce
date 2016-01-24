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

namespace WellCommerce\Bundle\GeneratorBundle\Resolver;

use Symfony\Component\Finder\Finder;

/**
 * Class ExtraMappingResolver
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtraMappingResolver extends AbstractResolver
{
    /**
     * @var string
     */
    protected $baseFileNamePattern;

    /**
     * @var string
     */
    protected $baseSearchPattern;

    /**
     * @var string
     */
    protected $extendedFileNamePattern;

    /**
     * @var string
     */
    protected $extendedSearchPattern;

    /**
     * ExtraMappingResolver constructor.
     *
     * @param string $baseFileNamePattern
     * @param string $baseSearchPattern
     * @param string $extendedFileNamePattern
     * @param string $extendedSearchPattern
     */
    public function __construct($baseFileNamePattern, $baseSearchPattern, $extendedFileNamePattern, $extendedSearchPattern)
    {
        $this->baseFileNamePattern     = $baseFileNamePattern;
        $this->baseSearchPattern       = $baseSearchPattern;
        $this->extendedFileNamePattern = $extendedFileNamePattern;
        $this->extendedSearchPattern   = $extendedSearchPattern;
    }

    /**
     * @return array
     */
    public function resolve()
    {
        $extraMappings  = $this->getExtraMapping();
        $baseMappings   = $this->getBaseMapping();
        $mergedMappings = [];

        foreach ($extraMappings as $extraClass => $extraMapping) {
            if (isset($baseMappings[$extraClass]) && !empty($extraMapping)) {
                $mergedMappings[$extraClass] = array_replace_recursive($baseMappings[$extraClass], $extraMapping);
            }
        }

        return $mergedMappings;
    }

    /**
     * Returns the WellCommerce's extra mapping
     *
     * @return array
     */
    protected function getExtraMapping()
    {
        $fileNamePattern   = 'extra.orm.yml';
        $searchPathPattern = 'src/*/*/*/Resources/config';

        return $this->parseFiles($fileNamePattern, $searchPathPattern);
    }

    /**
     * Returns the Doctrine's base mapping
     *
     * @return array
     */
    protected function getBaseMapping()
    {
        $fileNamePattern   = '*.orm.yml';
        $searchPathPattern = 'src/*/*/*/Resources/config/doctrine';

        return $this->parseFiles($fileNamePattern, $searchPathPattern);
    }

    /**
     * Parses found files and returns the results as an array
     *
     * @param $fileNamePattern
     * @param $searchPathPattern
     *
     * @return array
     */
    private function parseFiles($fileNamePattern, $searchPathPattern)
    {
        $finder = new Finder();
        $finder->name($fileNamePattern);
        $mapping = [];

        foreach ($finder->in($searchPathPattern) as $file) {
            $contents = $this->parseFile($file);
            if (is_array($contents)) {
                $mapping = array_replace_recursive($mapping, $contents);
            }
        }

        return $mapping;
    }
}
