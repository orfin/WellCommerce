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

namespace WellCommerce\Bundle\ApiBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use WellCommerce\Bundle\ApiBundle\Metadata\Collection\AssociationMetadataCollection;
use WellCommerce\Bundle\ApiBundle\Metadata\Collection\FieldMetadataCollection;

/**
 * Class EntityNormalizer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityNormalizer extends AbstractSerializer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $this->format                     = $format;
        $this->context                    = $context;
        $data                             = [];
        $entityMetadata                   = $this->getEntityMetadata($object);
        $serializationMetadata            = $this->getSerializationMetadata($object);
        $serializedFieldsCollection       = $serializationMetadata->getFields();
        $serializedAssociationsCollection = $serializationMetadata->getAssociations();
        
        $this->normalizeFields(
            $this->getEntityFields($entityMetadata),
            $serializedFieldsCollection,
            $object,
            $data
        );
        
        $this->normalizeEmbeddables(
            $this->getEntityEmbeddables($entityMetadata),
            $serializedFieldsCollection,
            $object,
            $data
        );
        
        $this->normalizeAssociations(
            $this->getEntityAssociations($entityMetadata),
            $serializedAssociationsCollection,
            $object,
            $data
        );
        
        return $data;
    }
    
    /**
     * Normalizes the entity's fields
     *
     * @param array                   $fields
     * @param FieldMetadataCollection $collection
     * @param object                  $object
     * @param array                   $data
     */
    protected function normalizeFields(array $fields, FieldMetadataCollection $collection, $object, array &$data)
    {
        foreach ($fields as $field) {
            if ($this->isFieldSerializable($field, $collection)) {
                $value = $this->propertyAccessor->getValue($object, $field);
                $this->propertyAccessor->setValue($data, $this->getPropertyPath($field), $value);
            }
        }
    }
    
    /**
     * Normalizes the entity's embeddables
     *
     * @param array                   $embeddables
     * @param FieldMetadataCollection $collection
     * @param object                  $object
     * @param array                   $data
     */
    protected function normalizeEmbeddables(array $embeddables, FieldMetadataCollection $collection, $object, array &$data)
    {
        foreach ($embeddables as $embedabbleName) {
            if ($this->isEmbeddableSerializable($embedabbleName, $collection)) {
                $value = $this->propertyAccessor->getValue($object, $embedabbleName);
                if (null !== $value && !is_scalar($value)) {
                    $value = $this->serializer->normalize($value, $this->format, $this->context);
                }
                $this->propertyAccessor->setValue($data, $this->getPropertyPath($embedabbleName), $value);
            }
        }
    }
    
    /**
     * Normalizes the entity's associations
     *
     * @param array                         $associations
     * @param AssociationMetadataCollection $collection
     * @param object                        $object
     * @param array                         $data
     */
    protected function normalizeAssociations(array $associations, AssociationMetadataCollection $collection, $object, array &$data)
    {
        foreach ($associations as $association) {
            if ($this->isAssociationSerializable($association, $collection)) {
                $value = $this->propertyAccessor->getValue($object, $association);
                if (null !== $value && !is_scalar($value)) {
                    $value = $this->serializer->normalize($value, $this->format, $this->context);
                }
                $this->propertyAccessor->setValue($data, $this->getPropertyPath($association), $value);
            }
        }
    }
    
    /**
     * Checks whether the field is serializable
     *
     * @param string                  $fieldName
     * @param FieldMetadataCollection $collection
     *
     * @return bool
     */
    protected function isFieldSerializable($fieldName, FieldMetadataCollection $collection)
    {
        if ($collection->has($fieldName)) {
            $field = $collection->get($fieldName);
            
            return ($field->hasGroup($this->context['group']) || $field->hasDefaultGroup());
        }
        
        return false;
    }
    
    /**
     * Checks whether the embeddable field is serializable
     *
     * @param string                  $embeddableName
     * @param FieldMetadataCollection $collection
     *
     * @return bool
     */
    protected function isEmbeddableSerializable($embeddableName, FieldMetadataCollection $collection)
    {
        if ($collection->has($embeddableName)) {
            $embeddable = $collection->get($embeddableName);
            
            return ($embeddable->hasGroup($this->context['group']) || $embeddable->hasDefaultGroup());
        }
        
        return false;
    }
    
    /**
     * Checks whether the association is serializable
     *
     * @param string                        $associationName
     * @param AssociationMetadataCollection $collection
     *
     * @return bool
     */
    protected function isAssociationSerializable($associationName, AssociationMetadataCollection $collection)
    {
        if ($collection->has($associationName)) {
            $association = $collection->get($associationName);
            
            return ($association->hasGroup($this->context['group']) || $association->hasDefaultGroup());
        }
        
        return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        if (!is_object($data)) {
            return false;
        }
        
        return $this->doctrineHelper->hasClassMetadataForEntity($data);
    }
}
