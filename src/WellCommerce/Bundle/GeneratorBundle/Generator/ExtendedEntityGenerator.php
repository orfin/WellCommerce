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

namespace WellCommerce\Bundle\GeneratorBundle\Generator;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\Helper\Helper;
use WellCommerce\Bundle\GeneratorBundle\Dumper\EntityDumperInterface;
use WellCommerce\Bundle\GeneratorBundle\Reflection\ClassAnalyzer;
use Wingu\OctopusCore\CodeGenerator\CodeLineGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\ClassGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\MethodGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\Modifiers;
use Wingu\OctopusCore\CodeGenerator\PHP\OOP\PropertyGenerator;
use Wingu\OctopusCore\CodeGenerator\PHP\ParameterGenerator;

/**
 * Class EntitiesExtraGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExtendedEntityGenerator extends AbstractContainerAware
{
    const EXTENDED_CLASS_SUFFIX = 'Extended';

    /**
     * @var ClassAnalyzer
     */
    protected $classAnalyzer;

    /**
     * @var EntityDumperInterface
     */
    protected $dumper;

    /**
     * @var string
     */
    protected $extendedEntityNamespace;

    /**
     * ExtendedEntityGenerator constructor.
     *
     * @param ClassAnalyzer         $classAnalyzer
     * @param EntityDumperInterface $dumper
     * @param string                $extendedEntityNamespace
     */
    public function __construct(ClassAnalyzer $classAnalyzer, EntityDumperInterface $dumper, $extendedEntityNamespace)
    {
        $this->classAnalyzer           = $classAnalyzer;
        $this->dumper                  = $dumper;
        $this->extendedEntityNamespace = $extendedEntityNamespace;
    }

    public function generateExtendedEntity(\ReflectionClass $baseEntity, array $mapping)
    {
        $fields     = $mapping['fields'];
        $generator  = $this->initGenerator($baseEntity);
        $targetPath = $this->resolveTargetPath($baseEntity);

//        $dumper->dump('app/config/generated/doctrine/' . $baseEntity->getShortName() . '.orm.yml', [
//            $extraMappingClass => $extraMappingContent
//        ]);

        $this->addFieldProperties($baseEntity, $generator, $fields);
        $this->addFieldGetters($baseEntity, $generator, $fields);
        $this->addFieldSetters($baseEntity, $generator, $fields);

        return $this->dumper->dump($targetPath, $generator);
    }

    /**
     * @param \ReflectionClass $baseEntity
     *
     * @return string
     */
    protected function getExtendedEntityName(\ReflectionClass $baseEntity)
    {
        return sprintf('%s%s', $baseEntity->getShortName(), self::EXTENDED_CLASS_SUFFIX);
    }

    /**
     * Returns target path for extended entity. Extended entities are stored in the same folder as base entity.
     *
     * @param \ReflectionClass $baseEntity
     *
     * @return string
     */
    protected function resolveTargetPath(\ReflectionClass $baseEntity)
    {
        $baseEntityPaths = explode(DIRECTORY_SEPARATOR, $baseEntity->getFileName());

        array_pop($baseEntityPaths);

        return implode(DIRECTORY_SEPARATOR, $baseEntityPaths);
    }

    /**
     * Initializes the generator for extended entity
     *
     * @param string           $extendedEntityName
     * @param \ReflectionClass $baseEntity
     *
     * @return ClassGenerator
     */
    protected function initGenerator(\ReflectionClass $baseEntity)
    {
        $generator = new ClassGenerator($this->getExtendedEntityName($baseEntity), $baseEntity->getNamespaceName());
        $generator->setAbstract(false);
        $generator->setExtends($baseEntity->getShortName());

        return $generator;
    }

    /**
     * Adds the field's properties
     *
     * @param \ReflectionClass $baseEntity
     * @param ClassGenerator   $generator
     * @param array            $fields
     */
    protected function addFieldProperties(\ReflectionClass $baseEntity, ClassGenerator $generator, array $fields)
    {
        foreach ($fields as $fieldName => $fieldConfiguration) {
            if (false === $this->classAnalyzer->hasProperty($baseEntity, $fieldName)) {
                $generator->addProperty(new PropertyGenerator($fieldName, null, Modifiers::MODIFIER_PROTECTED));
            }
        }
    }

    /**
     * Adds the field's getters
     *
     * @param \ReflectionClass $baseEntity
     * @param ClassGenerator   $generator
     * @param array            $fields
     */
    protected function addFieldGetters(\ReflectionClass $baseEntity, ClassGenerator $generator, array $fields)
    {
        foreach ($fields as $fieldName => $fieldConfiguration) {
            $getterMethod = 'get' . Helper::studly($fieldName);
            $variableName = strval($fieldName);

            if (false === $this->classAnalyzer->hasMethod($baseEntity, $getterMethod)) {
                $method = new MethodGenerator($getterMethod);
                $method->addBodyLine(new CodeLineGenerator('return $this->' . $variableName . ';'));
                $method->setVisibility(Modifiers::VISIBILITY_PUBLIC);
                $generator->addMethod($method);
            }
        }
    }

    /**
     * Adds the field's setters
     *
     * @param \ReflectionClass $baseEntity
     * @param ClassGenerator   $generator
     * @param array            $fields
     */
    protected function addFieldSetters(\ReflectionClass $baseEntity, ClassGenerator $generator, array $fields)
    {
        foreach ($fields as $fieldName => $fieldConfiguration) {
            $setterMethod = 'set' . Helper::studly($fieldName);
            $variableName = strval($fieldName);

            if (false === $this->classAnalyzer->hasMethod($baseEntity, $setterMethod)) {
                $method = new MethodGenerator($setterMethod);
                $method->addBodyLine(new CodeLineGenerator('$this->' . $variableName . ' = $' . $variableName . ';'));
                $method->addParameter(new ParameterGenerator($variableName, null));
                $method->setVisibility(Modifiers::VISIBILITY_PUBLIC);
                $generator->addMethod($method);
            }
        }
    }
}
