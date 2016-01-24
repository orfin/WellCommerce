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

        $parentClass = $class->getParentClass();

        if (false === $parentClass) {
            return false;
        }

        return $this->hasProperty($parentClass, $propertyName);
    }
}
