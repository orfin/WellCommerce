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

namespace WellCommerce\Bundle\DistributionBundle\Generator;

use WellCommerce\Bundle\DistributionBundle\Collection\MappingCollection;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;

/**
 * Interface EntityExtraTraitGeneratorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EntityExtraTraitGeneratorInterface
{
    /**
     * Generates a trait content from mapping definition
     *
     * @param MappingDefinition $definition
     *
     * @return string
     */
    public function generateTrait(MappingDefinition $definition);
}
