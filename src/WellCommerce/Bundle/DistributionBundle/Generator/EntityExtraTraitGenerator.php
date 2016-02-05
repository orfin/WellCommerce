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

use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\CoreBundle\Helper\Reflection\ReflectionHelperInterface;
use WellCommerce\Bundle\DistributionBundle\Definition\EntityExtraTraitDefinition;
use WellCommerce\Bundle\DistributionBundle\Definition\MappingDefinition;
use Wingu\OctopusCore\CodeGenerator\CodeLineGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\MethodGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\Modifiers;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\PropertyGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\TraitGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\ParameterGenerator;

/**
 * Class EntityExtraTraitGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityExtraTraitGenerator implements EntityExtraTraitGeneratorInterface
{
    /**
     * @var ReflectionHelperInterface
     */
    protected $reflectionHelper;

    /**
     * EntityExtraTraitGenerator constructor.
     *
     * @param ReflectionHelperInterface $reflectionHelper
     */
    public function __construct(ReflectionHelperInterface $reflectionHelper)
    {
        $this->reflectionHelper = $reflectionHelper;
    }

    /**
     * Generates a trait and returns it as a definition
     *
     * @param MappingDefinition $definition
     *
     * @return bool|EntityExtraTraitDefinition
     */
    public function generateTrait(MappingDefinition $definition)
    {
        $reflectionClass      = $definition->getReflectionClass();
        $traitReflectionClass = $this->reflectionHelper->getEntityExtraTrait($reflectionClass);

        if ($traitReflectionClass instanceof \ReflectionClass) {
            $generator = $this->extendTrait($definition, $traitReflectionClass);
            $content   = $this->prepareTraitContent($generator);

            return new EntityExtraTraitDefinition($traitReflectionClass, $content);
        }

        return false;
    }

    /**
     * Returns the trait generator
     *
     * @param MappingDefinition $definition
     * @param \ReflectionClass  $traitReflectionClass
     *
     * @return TraitGenerator
     */
    protected function extendTrait(MappingDefinition $definition, \ReflectionClass $traitReflectionClass)
    {
        $properties = $this->getRequiredProperties($definition);
        $generator  = new TraitGenerator($traitReflectionClass->getShortName(), $traitReflectionClass->getNamespaceName());

        foreach ($properties as $property) {
            $this->addProperty($generator, $property);
            $this->addGetterMethod($generator, $property);
            $this->addSetterMethod($generator, $property);
        }

        return $generator;
    }

    /**
     * Adds a property to generator
     *
     * @param TraitGenerator $generator
     * @param string         $property
     */
    protected function addProperty(TraitGenerator $generator, $property)
    {
        $generator->addProperty(new PropertyGenerator($property, null, Modifiers::MODIFIER_PROTECTED));
    }

    /**
     * Adds a getter method to generator
     *
     * @param TraitGenerator $generator
     * @param string         $property
     */
    protected function addGetterMethod(TraitGenerator $generator, $property)
    {
        $getterMethodName = 'get' . Helper::studly($property);
        $variableName     = strval($property);

        $method = new MethodGenerator($getterMethodName);
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
    protected function addSetterMethod(TraitGenerator $generator, $property)
    {
        $setterMethodName = 'set' . Helper::studly($property);
        $variableName     = strval($property);

        $method = new MethodGenerator($setterMethodName);
        $method->addBodyLine(new CodeLineGenerator('$this->' . $variableName . ' = $' . $variableName . ';'));
        $method->addParameter(new ParameterGenerator($variableName));
        $method->setVisibility(Modifiers::VISIBILITY_PUBLIC);

        $generator->addMethod($method);
    }

    /**
     * Returns an array of required properties
     *
     * @param MappingDefinition $definition
     *
     * @return array
     */
    protected function getRequiredProperties(MappingDefinition $definition)
    {
        $fields     = $definition->getFields();
        $properties = [];

        foreach ($fields as $fieldName => $fieldProperties) {
            $properties[] = $fieldName;
        }

        return $properties;
    }

    /**
     * Prepares the extended entity trait content
     *
     * @param TraitGenerator $generator
     *
     * @return string
     */
    protected function prepareTraitContent(TraitGenerator $generator)
    {
        $content
            = <<<EOT
<?php

# WellCommerce Open-Source E-Commerce Platform
#
# This file is part of the WellCommerce package.
# (c) Adam Piotrowski <adam@wellcommerce.org>
#
# For the full copyright and license information,
# please view the LICENSE file that was distributed with this source code.
#
# File was auto-generated by WellCommerceDistributionBundle

EOT;
        $content .= PHP_EOL . $generator->generate();

        return $content;
    }
}
