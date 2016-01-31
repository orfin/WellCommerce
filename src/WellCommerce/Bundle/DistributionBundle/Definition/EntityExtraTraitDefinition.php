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

namespace WellCommerce\Bundle\DistributionBundle\Definition;

/**
 * Class EntityExtraTraitDefinition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityExtraTraitDefinition
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @var string
     */
    protected $source;

    /**
     * EntiryExtraTraitDefinition constructor.
     *
     * @param \ReflectionClass $reflectionClass
     * @param string           $source
     */
    public function __construct(\ReflectionClass $reflectionClass, $source)
    {
        $this->reflectionClass = $reflectionClass;
        $this->source          = $source;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}
