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

namespace WellCommerce\Bundle\CoreBundle\Helper\Reflection;

use ReflectionClass;

/**
 * Class ReflectionHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReflectionHelper implements ReflectionHelperInterface
{
    /**
     * {@inheritdoc}
     */
    public function hasTrait(ReflectionClass $class, $traitName)
    {
        return in_array($traitName, $class->getTraitNames());
    }

    /**
     * {@inheritdoc}
     */
    public function hasMethod(ReflectionClass $class, $methodName)
    {
        return $class->hasMethod($methodName);
    }

    /**
     * {@inheritdoc}
     */
    public function hasConstant(ReflectionClass $class, $constantName)
    {
        return $class->hasConstant($constantName);
    }

    /**
     * {@inheritdoc}
     */
    public function hasProperty(ReflectionClass $class, $propertyName)
    {
        if ($class->hasProperty($propertyName)) {
            return true;
        }

        $traits = $class->getTraits();
        foreach ($traits as $trait) {
            if ($trait->hasProperty($propertyName)) {
                return true;
            }
        }

        $parentClass = $class->getParentClass();

        if (false === $parentClass) {
            return false;
        }

        return $this->hasProperty($parentClass, $propertyName);
    }

    /**
     * @param ReflectionClass $class
     *
     * @return bool
     */
    public function hasEntityExtraTrait(ReflectionClass $class)
    {
        return $this->hasTrait($class, $this->getEntityExtraTraitName($class));
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityExtraTrait(ReflectionClass $class)
    {
        $traits = $class->getTraits();
        foreach ($traits as $trait) {
            if ($trait->getName() == $this->getEntityExtraTraitName($class)) {
                return $trait;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityExtraTraitName(ReflectionClass $class)
    {
        return sprintf('%s\\Extra\\%sExtraTrait', $class->getNamespaceName(), $class->getShortName());
    }
}
