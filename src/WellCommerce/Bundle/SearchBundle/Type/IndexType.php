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

namespace WellCommerce\Bundle\SearchBundle\Type;

/**
 * Class IndexType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class IndexType implements IndexTypeInterface
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var
     */
    private $documentClass;
    
    /**
     * @var
     */
    private $entityClass;
    
    /**
     * @var array
     */
    private $mapping;
    
    /**
     * @var IndexTypeFieldCollection
     */
    private $fields;
    
    /**
     * IndexType constructor.
     *
     * @param string $name
     * @param string $documentClass
     * @param string $entityClass
     * @param array  $mapping
     */
    public function __construct(string $name, string $documentClass, string $entityClass, array $mapping)
    {
        $this->name          = $name;
        $this->documentClass = $documentClass;
        $this->entityClass   = $entityClass;
        $this->mapping       = $mapping;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getEntityClass() : string
    {
        return $this->name;
    }
    
    public function getFields() : IndexTypeFieldCollection
    {
        if (null === $this->fields) {
            $this->fields = $this->processMappingConfiguration();
        }
        
        return $this->fields;
    }
    
    private function processMappingConfiguration() : IndexTypeFieldCollection
    {
        $collection = new IndexTypeFieldCollection();
        
        foreach ($this->mapping as $name => $options) {
            $field = new IndexTypeField($name, $options);
            $collection->set($name, $field);
        }
        
        return $collection;
    }
}
