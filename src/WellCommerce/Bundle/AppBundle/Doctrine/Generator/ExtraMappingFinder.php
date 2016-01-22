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

namespace WellCommerce\Bundle\AppBundle\Doctrine\Generator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ExtraMappingFinder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtraMappingFinder
{
    const EXTRA_MAPPING_FILE         = 'extra.orm.yml';
    const EXTRA_MAPPING_PATH_PATTERN = 'src/*/*/*/Resources/config';

    /**
     * @return array
     */
    public function getExtraMappings()
    {
        $mappings = [];
        $files    = $this->getMappingFiles();
        foreach ($files as $file) {
            $mappings = array_merge_recursive($mappings, $this->parseFile($file));
        }

        return $mappings;
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return array
     */
    private function parseFile(\SplFileInfo $file)
    {
        return Yaml::parse($file->getContents());
    }

    /**
     * @return $this|Finder
     */
    private function getMappingFiles()
    {
        $finder = new Finder();
        $finder->name(self::EXTRA_MAPPING_FILE);

        return $finder->in(self::EXTRA_MAPPING_PATH_PATTERN);
    }
}
