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

namespace WellCommerce\Bundle\DistributionBundle\Collection;

use Symfony\Component\Finder\SplFileInfo;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class MappingCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingCollection extends ArrayCollection
{
    /**
     * Adds new mapping definition to collection
     *
     * @param MappingDefinition $definition
     */
    public function add(MappingDefinition $definition)
    {
        $this->items[$definition->getClassName()] = $definition;
    }

    /**
     * Updates an existing mapping definition
     *
     * @param string $id
     * @param array  $mapping
     */
    public function update($id, $mapping)
    {
        $definition = $this->get($id);
        $mapping    = array_replace_recursive($definition->getMapping(), $mapping);
        $definition->setMapping($mapping);
    }
}
