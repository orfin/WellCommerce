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

namespace WellCommerce\Bundle\ApiBundle\Metadata;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\ApiBundle\Metadata\Collection;
use WellCommerce\Bundle\ApiBundle\Metadata\Factory\AssociationMetadataFactory;
use WellCommerce\Bundle\ApiBundle\Metadata\Factory\FieldMetadataFactory;

/**
 * Class ClassMetadata
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationClassMetadata implements SerializationClassMetadataInterface
{
    /**
     * @var string
     */
    protected $class;
    
    /**
     * @var array
     */
    protected $options = [];
    
    /**
     * SerializationClassMetadata constructor.
     *
     * @param string $class
     * @param array  $options
     */
    public function __construct($class, array $options = [])
    {
        $this->class = $class;
        $resolver    = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'fields',
            'associations',
            'callbacks',
        ]);
        
        $fieldsNormalizer = function (Options $options, $fields) {
            $collection = new Collection\FieldMetadataCollection();
            $factory    = new FieldMetadataFactory();
            
            foreach ($fields as $fieldName => $parameters) {
                $fieldMetadata = $factory->create($fieldName, $parameters);
                $collection->add($fieldMetadata);
            }
            
            return $collection;
        };
        
        $associationsNormalizer = function (Options $options, $associations) {
            $collection = new Collection\AssociationMetadataCollection();
            $factory    = new AssociationMetadataFactory();
            
            foreach ($associations as $associationName => $parameters) {
                $associationMetadata = $factory->create($associationName, $parameters);
                $collection->add($associationMetadata);
            }
            
            return $collection;
        };
        
        $resolver->setNormalizer('fields', $fieldsNormalizer);
        $resolver->setNormalizer('associations', $associationsNormalizer);
        
        $resolver->setDefaults([
            'fields'       => new Collection\FieldMetadataCollection(),
            'associations' => new Collection\AssociationMetadataCollection(),
            'callbacks'    => [],
        ]);
        
        $resolver->setAllowedTypes('fields', ['array', Collection\FieldMetadataCollection::class]);
        $resolver->setAllowedTypes('associations', ['array', Collection\AssociationMetadataCollection::class]);
        $resolver->setAllowedTypes('callbacks', 'array');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->options['fields'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAssociations()
    {
        return $this->options['associations'];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCallbacks()
    {
        return $this->options['callbacks'];
    }
}
