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
 * Interface ReflectionHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReflectionHelperInterface
{
    /**
     * Checks whether the class has trait
     *
     * @param ReflectionClass $class
     * @param string          $traitName
     *
     * @return bool
     */
    public function hasTrait(ReflectionClass $class, $traitName);

    /**
     * Checks whether the class has method
     *
     * @param ReflectionClass $class
     * @param string          $methodName
     *
     * @return bool
     */
    public function hasMethod(ReflectionClass $class, $methodName);

    /**
     * Checks whether the class has constant
     *
     * @param ReflectionClass $class
     * @param string          $constantName
     *
     * @return bool
     */
    public function hasConstant(ReflectionClass $class, $constantName);

    /**
     * Chacks whether the class has property
     *
     * @param ReflectionClass $class
     * @param string          $propertyName
     *
     * @return bool
     */
    public function hasProperty(ReflectionClass $class, $propertyName);
}
