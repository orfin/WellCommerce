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
 * Interface EntityExtraTraitDumperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EntityExtraTraitDumperInterface
{
    /**
     * Dumps a collection of mappings to generated extra traits
     *
     * @param MappingCollection $collection
     *
     * @return string
     */
    public function dumpCollection(MappingCollection $collection);

    /**
     * Dumps a single mapping definition to extra trait
     *
     * @param MappingDefinition $definition
     *
     * @return string
     */
    public function dumpDefinition(MappingDefinition $definition);
}
