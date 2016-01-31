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

namespace WellCommerce\Bundle\DistributionBundle\Merger;

use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Class MappingMerger
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingMerger implements MappingMergerInterface
{
    /**
     * {@inheritdoc}
     */
    public function merge(MappingDefinition $extraDefinition, MappingDefinition $baseDefinition)
    {
        $extraMapping  = $extraDefinition->getMapping();
        $baseMapping   = $baseDefinition->getMapping();
        $mergedMapping = array_replace_recursive($baseMapping, $extraMapping);

        $extraDefinition->setMapping($mergedMapping);
    }
}
