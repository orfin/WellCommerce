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

namespace WellCommerce\Bundle\DistributionBundle\Parser;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Yaml\Yaml;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Collection\MappingFilesCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Class MappingParser
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingParser implements MappingParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parseFile(SplFileInfo $file)
    {
        $content = $file->getContents();

        return $this->parseContent($content);
    }

    /**
     * Parses the Yaml content
     *
     * @param string $content
     *
     * @return array
     */
    protected function parseContent($content)
    {
        return Yaml::parse($content);
    }
}
