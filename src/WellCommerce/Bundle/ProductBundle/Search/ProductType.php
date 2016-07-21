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

namespace WellCommerce\Bundle\ProductBundle\Search;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Component\Search\Model\DocumentInterface;
use WellCommerce\Component\Search\Model\Field;
use WellCommerce\Component\Search\Model\TypeInterface;

/**
 * Class ProductType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ProductType implements TypeInterface
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array
     */
    private $mapping;
    
    /**
     * @var Collection
     */
    private $fields;

    /**
     * ProductType constructor.
     *
     * @param string $name
     * @param array  $mapping
     */
    public function __construct(string $name, array $mapping)
    {
        $this->name    = $name;
        $this->mapping = $mapping;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function createDocument(EntityInterface $entity, string $locale) : DocumentInterface
    {
        if (!$entity instanceof ProductInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Wrong entity type "%s" was given. Type "%s" supports only instances of "%s"',
                get_class($entity),
                $this->getName(),
                ProductInterface::class
            ));
        }

        return new ProductDocument($entity, $this, $locale);
    }
    
    public function getFields() : Collection
    {
        if (null === $this->fields) {
            $this->fields = $this->processMappingConfiguration();
        }
        
        return $this->fields;
    }
    
    private function processMappingConfiguration() : Collection
    {
        $collection = new ArrayCollection();
        
        foreach ($this->mapping as $name => $options) {
            if($options['indexable']){
                $field = new Field($name, $options);
                $collection->set($name, $field);
            }
        }
        
        return $collection;
    }
}
