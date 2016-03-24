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

namespace WellCommerce\Bundle\DoctrineBundle\Enhancer;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\DoctrineBundle\Definition\MappingDefinitionCollection;
use WellCommerce\Bundle\DoctrineBundle\Definition\MappingDefinitionInterface;
use Wingu\OctopusCore\CodeGenerator\CodeLineGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\MethodGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\Modifiers;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\PropertyGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\ParameterGenerator;

/**
 * Class AbstractMappingEnhancer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractMappingEnhancer implements MappingEnhancerInterface
{
    abstract protected function configureMappingDefinition(MappingDefinitionCollection $collection);

    /**
     * @return MappingDefinitionCollection
     */
    protected function getMappingDefinitionCollection()
    {
        $collection = new MappingDefinitionCollection();
        $this->configureMappingDefinition($collection);

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function visitClassMetadata(ClassMetadataInfo $metadata)
    {
        $collection = $this->getMappingDefinitionCollection();
        $this->extendClassMetadata($metadata, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function visitTraitGenerator(TraitGenerator $generator)
    {
        $collection = $this->getMappingDefinitionCollection();
        $this->extendTrait($generator, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEntity(string $className) : bool
    {
        return $className === $this->getSupportedEntityClass();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEntityExtraTrait(string $className) : bool
    {
        return $className === $this->getSupportedEntityExtraTraitClass();
    }

    /**
     * Extends the mapping
     *
     * @param ClassMetadataInfo           $metadata
     * @param MappingDefinitionCollection $collection
     */
    private function extendClassMetadata(ClassMetadataInfo $metadata, MappingDefinitionCollection $collection)
    {
        $collection->forAll(function (MappingDefinitionInterface $definition) use ($metadata) {
            $reflectionClass = $metadata->getReflectionClass();
            if (true === $reflectionClass->hasProperty($definition->getPropertyName())) {
                $metadata->{$definition->getClassMetadataMethod()}($definition->getOptions());
            }
        });
    }

    /**
     * Extend the trait
     *
     * @param TraitGenerator              $generator
     * @param MappingDefinitionCollection $collection
     */
    private function extendTrait(TraitGenerator $generator, MappingDefinitionCollection $collection)
    {
        $collection->forAll(function (MappingDefinitionInterface $definition) use ($generator) {
            $this->addProperty($generator, $definition->getPropertyName());
            $this->addGetterMethod($generator, $definition->getPropertyName());
            $this->addSetterMethod($generator, $definition->getPropertyName());
        });
    }

    /**
     * Adds a property to generator
     *
     * @param TraitGenerator $generator
     * @param string         $property
     */
    protected function addProperty(TraitGenerator $generator, string $property)
    {
        $generator->addProperty(new PropertyGenerator($property, null, Modifiers::MODIFIER_PROTECTED));
    }

    /**
     * Adds a getter method to generator
     *
     * @param TraitGenerator $generator
     * @param string         $property
     */
    protected function addGetterMethod(TraitGenerator $generator, string $property)
    {
        $getterMethodName = 'get' . Helper::studly($property);
        $variableName     = strval($property);
        $method           = new MethodGenerator($getterMethodName);
        $method->addBodyLine(new CodeLineGenerator('return $this->' . $variableName . ';'));
        $method->setVisibility(Modifiers::VISIBILITY_PUBLIC);
        $generator->addMethod($method);
    }

    /**
     * Adds a setter method to generator
     *
     * @param TraitGenerator $generator
     * @param string         $property
     */
    protected function addSetterMethod(TraitGenerator $generator, string $property)
    {
        $setterMethodName = 'set' . Helper::studly($property);
        $variableName     = strval($property);
        $method           = new MethodGenerator($setterMethodName);
        $method->addBodyLine(new CodeLineGenerator('$this->' . $variableName . ' = $' . $variableName . ';'));
        $method->addParameter(new ParameterGenerator($variableName));
        $method->setVisibility(Modifiers::VISIBILITY_PUBLIC);
        $generator->addMethod($method);
    }
}
