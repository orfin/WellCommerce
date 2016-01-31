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

use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Interface MappingDumperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingDumperInterface
{
    const FILENAME_PATTERN = '%s.orm.yml';

    /**
     * @param MappingCollection $collection
     */
    public function dumpCollection(MappingCollection $collection);

    /**
     * @param MappingDefinition $definition
     */
    public function dumpDefinition(MappingDefinition $definition);

    /**
     * @return string
     */
    public function getTargetPath();
}
