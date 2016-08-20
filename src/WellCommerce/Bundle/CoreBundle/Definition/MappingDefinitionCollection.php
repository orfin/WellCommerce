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

namespace WellCommerce\Bundle\CoreBundle\Definition;

use WellCommerce\Component\Collections\ArrayCollection;

/**
 * Class MappingDefinitionCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingDefinitionCollection extends ArrayCollection
{
    /**
     * @param MappingDefinitionInterface $mappingDefinition
     */
    public function add(MappingDefinitionInterface $mappingDefinition)
    {
        $this->items[] = $mappingDefinition;
    }

    /**
     * @return MappingDefinitionInterface[]
     */
    public function all()
    {
        return $this->items;
    }
}
