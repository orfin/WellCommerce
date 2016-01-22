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

namespace WellCommerce\Bundle\AppBundle\Doctrine\Generator;

use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\TraitGenerator;
use Zend\Code\Reflection\ClassReflection;

/**
 * Class EntitiesExtraGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntitiesExtraGenerator
{
    /**
     * Generates the extra entity code
     *
     * @param \ReflectionClass $class
     * @param array            $extraMapping
     */
    public function generateEntityExtra(\ReflectionClass $class, array $extraMapping)
    {
        $traitName       = TraitAnalyzer::getEntityExtraTraitName($class);
        $traitReflection = new ClassReflection($traitName);
        $generator       = TraitGenerator::fromReflection($traitReflection);

        foreach ($extraMapping['fields'] as $fieldName => $fieldOptions) {
            $this->addProperty($fieldName, $generator, $traitReflection);
            $this->addGetter($fieldName, $generator, $traitReflection);
            $this->addSetter($fieldName, $generator, $traitReflection);
        }

        file_put_contents($traitReflection->getFileName(), '<?php' . str_repeat(PHP_EOL, 2) . $generator->generate(), LOCK_EX);
    }

    /**
     * Adds the property if not yet exists
     *
     * @param string           $fieldName
     * @param ClassGenerator   $generator
     * @param \ReflectionClass $trait
     */
    protected function addProperty($fieldName, ClassGenerator $generator, \ReflectionClass $trait)
    {
        if (false === $trait->hasProperty($fieldName)) {
            $generator->addProperty($fieldName, null, PropertyGenerator::FLAG_PROTECTED);
        }
    }

    /**
     * Adds the getter method to generator
     *
     * @param string           $fieldName
     * @param ClassGenerator   $generator
     * @param \ReflectionClass $trait
     */
    protected function addGetter($fieldName, ClassGenerator $generator, \ReflectionClass $trait)
    {
        $methodName = 'get' . Helper::studly($fieldName);

        if (false === $trait->hasMethod($methodName)) {
            $generator->addMethod(
                $methodName,
                [],
                MethodGenerator::FLAG_PUBLIC,
                'return $this->' . strval($fieldName) . ';'
            );
        }
    }

    /**
     * Adds the setter method to generator
     *
     * @param string           $fieldName
     * @param ClassGenerator   $generator
     * @param \ReflectionClass $trait
     */
    protected function addSetter($fieldName, ClassGenerator $generator, \ReflectionClass $trait)
    {
        $methodName = 'set' . Helper::studly($fieldName);

        if (false === $trait->hasMethod($methodName)) {
            $generator->addMethod(
                $methodName,
                [$fieldName],
                MethodGenerator::FLAG_PUBLIC,
                '$this->' . strval($fieldName) . ' = $' . strval($fieldName) . ';'
            );
        }
    }
}
