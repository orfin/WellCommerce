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

namespace WellCommerce\Bundle\AvailabilityBundle\Plugin;

use WellCommerce\Bundle\PluginBundle\Definition\FieldDefinition;
use WellCommerce\Bundle\PluginBundle\Definition\ManyToManyDefinition;
use WellCommerce\Bundle\PluginBundle\Definition\MappingDefinitionCollection;
use WellCommerce\Bundle\PluginBundle\Visitor\ClassMetadata\AbstractClassMetadataVisitor;

/**
 * Class AvailabilityClassMetadataVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityClassMetadataVisitor extends AbstractClassMetadataVisitor
{
    /**
     * @param MappingDefinitionCollection $collection
     */
    protected function configureMappingDefinition(MappingDefinitionCollection $collection)
    {
        $collection->add(new FieldDefinition([
            'fieldName'  => 'name',
            'type'       => 'string',
            'length'     => 50,
            'unique'     => true,
            'nullable'   => true,
            'columnName' => 'name',
        ]));

        $collection->add(new FieldDefinition([
            'fieldName'  => 'type',
            'type'       => 'string',
            'length'     => 255,
            'unique'     => true,
            'nullable'   => true,
            'columnName' => 'name',
        ]));

        $collection->add(new ManyToManyDefinition([
            'fieldName'    => 'groups',
            'targetEntity' => 'WellCommerce\Bundle\Availability',
        ]));
    }

    public function getSupportedEntityClass()
    {
        return \WellCommerce\Bundle\AvailabilityBundle\Entity\Availability::class;
    }

    public function getSupportedEntityExtraTraitClass()
    {
        return \WellCommerce\Bundle\AvailabilityBundle\Entity\Extra\AvailabilityExtraTrait::class;
    }
}
