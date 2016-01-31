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

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Interface MappingMergerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface MappingMergerInterface
{
    /**
     * Merges two mapping definitions
     *
     * @param MappingDefinition $extraDefinition
     * @param MappingDefinition $baseDefinition
     */
    public function merge(MappingDefinition $extraDefinition, MappingDefinition $baseDefinition);
}
