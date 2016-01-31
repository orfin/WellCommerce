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

namespace WellCommerce\Bundle\PluginBundle\Visitor\ClassMetadata;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use WellCommerce\Bundle\PluginBundle\Definition\MappingDefinitionCollection;
use Zend\Code\Generator\TraitGenerator;

/**
 * Class AbstractClassMetadataVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractClassMetadataVisitor implements ClassMetadataVisitorInterface
{
    public function visitClassMetadata(ClassMetadataInfo $metadata)
    {
        $collection = $this->getMappingDefinitionCollection();
        print_r($mappings);
        die();
    }

    public function visitTraitGenerator(TraitGenerator $generator)
    {
        $collection = $this->getMappingDefinitionCollection();

    }

    /**
     * Maps field
     *
     * @param array             $field
     * @param ClassMetadataInfo $metadata
     */
    protected function mapField(array $field, ClassMetadataInfo $metadata)
    {
        $reflectionClass = $metadata->getReflectionClass();
        if ($reflectionClass->hasProperty($field['fieldName'])) {
            $metadata->mapField([
                'fieldName'  => 'name',
                'type'       => 'string',
                'length'     => 50,
                'unique'     => true,
                'nullable'   => true,
                'columnName' => 'name',
            ]);
        }
    }

    /**
     * @return MappingDefinitionCollection
     */
    public function getMappingDefinitionCollection()
    {
        $collection = new MappingDefinitionCollection();
        $this->configureMappingDefinition($collection);

        return $collection;
    }

    /**
     * @param MappingDefinitionCollection $collection
     */
    abstract protected function configureMappingDefinition(MappingDefinitionCollection $collection);
}
