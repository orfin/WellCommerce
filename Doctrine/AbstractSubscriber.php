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

namespace WellCommerce\Bundle\AppBundle\Doctrine;

/**
 * Class AbstractSubscriber
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractSubscriber
{
    /**
     * Checks whether the class contains such a method
     *
     * @param \ReflectionClass $class
     * @param string           $methodName
     *
     * @return bool
     */
    public function hasMethod(\ReflectionClass $class, $methodName)
    {
        return $class->hasMethod($methodName);
    }
}
