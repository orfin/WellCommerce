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
use WellCommerce\Bundle\DistributionBundle\Collection\MappingFilesCollection;

/**
 * Interface MappingParserInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingParserInterface
{
    /**
     * Parses the file's YAML content and returns it as an array
     *
     * @param SplFileInfo $file
     *
     * @return array
     */
    public function parseFile(SplFileInfo $file);
}
