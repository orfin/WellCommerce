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

/**
 * Class TraitAnalyzer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TraitAnalyzer
{
    /**
     * @return bool
     */
    public static function hasEntityExtraTrait(\ReflectionClass $class)
    {
        $traitName = self::getEntityExtraTraitName($class);

        return in_array($traitName, $class->getTraitNames());
    }

    /**
     * @param \ReflectionClass $class
     *
     * @return string
     */
    public static function getEntityExtraTraitName(\ReflectionClass $class)
    {
        return sprintf('%s\Extra\%sExtraTrait', $class->getNamespaceName(), $class->getShortName());
    }
}
