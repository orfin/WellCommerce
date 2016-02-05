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
 * Class MappingDefinition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MappingDefinition
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var array
     */
    protected $mapping;

    /**
     * MappingDefinition constructor.
     *
     * @param string $className
     * @param array  $mapping
     */
    public function __construct($className, array $mapping)
    {
        $this->className = $className;
        $this->mapping   = $mapping;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return isset($this->mapping['fields']) ? $this->mapping['fields'] : [];
    }

    /**
     * @param array $mapping
     */
    public function setMapping(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass()
    {
        return new \ReflectionClass($this->className);
    }
}
