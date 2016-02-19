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

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
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
        $data           = [];
        $entityMetadata = $this->getEntityMetadata($object);

        $this->updateDataFromFields($data, $entityMetadata, $object, $context);
        $this->updateDataFromAssociations($data, $entityMetadata, $object, $context, $format);

        return $data;
    }

    /**
     * Updates normalized data with entity fields values
     *
     * @param array         $data
     * @param ClassMetadata $metadata
     * @param object        $object
     * @param array         $context
     */
    protected function updateDataFromFields(array &$data = [], ClassMetadata $metadata, $object, array $context = [])
    {
        $serializationMetadata = $this->getSerializationMetadata($object);
        $serializedFields      = $serializationMetadata->getFields();

        foreach ($metadata->getFieldNames() as $fieldName) {
            $propertyName = $this->getPropertyNameForField($fieldName);
            if ($this->isFieldSerializable($propertyName, $serializedFields, $context['group'])) {
                $value = $this->propertyAccessor->getValue($object, $fieldName);
                $this->propertyAccessor->setValue($data, $this->getPropertyPath($fieldName), $value);
            }
        }
    }

    /**
     * Checks whether the field is serializable
     *
     * @param string                  $fieldName
     * @param FieldMetadataCollection $collection
     * @param string                  $currentGroup
     *
     * @return bool
     */
    protected function isFieldSerializable($fieldName, FieldMetadataCollection $collection, $currentGroup)
    {
        $propertyName = $this->getPropertyNameForField($fieldName);

        if ($collection->has($propertyName)) {
            $field = $collection->get($propertyName);
            return ($field->hasGroup($currentGroup) || $field->hasDefaultGroup());
        }

        return false;
    }

    /**
     * Checks whether the association is serializable
     *
     * @param string                        $associationName
     * @param AssociationMetadataCollection $collection
     * @param string                        $currentGroup
     *
     * @return bool
     */
    protected function isAssociationSerializable($associationName, AssociationMetadataCollection $collection, $currentGroup)
    {
        if ($collection->has($associationName)) {
            $association = $collection->get($associationName);

            return ($association->hasGroup($currentGroup) || $association->hasDefaultGroup());
        }

        return false;
    }

    /**
     * Updates normalized data with entity associations values
     *
     * @param array         $data
     * @param ClassMetadata $metadata
     * @param object        $object
     * @param array         $context
     * @param string|null   $format
     */
    protected function updateDataFromAssociations(array &$data = [], ClassMetadata $metadata, $object, array $context = [], $format = null)
    {
        $serializationMetadata  = $this->getSerializationMetadata($object);
        $serializedAssociations = $serializationMetadata->getAssociations();

        foreach ($metadata->getAssociationNames() as $associationName) {
            if ($this->isAssociationSerializable($associationName, $serializedAssociations, $context['group'])) {
                $propertyPath = $this->getPropertyPath($associationName);
                $value        = $this->getAssociationValue($object, $associationName, $format, $context);
                $this->propertyAccessor->setValue($data, $propertyPath, $value);
            }
        }
    }

    /**
     * Returns the value for association
     *
     * @param object $object
     * @param string $associationName
     * @param string $format
     * @param array  $context
     *
     * @return array|bool|float|int|mixed|null|string
     */
    protected function getAssociationValue($object, $associationName, $format, array $context = [])
    {
        $value = $this->propertyAccessor->getValue($object, $associationName);
        if (null !== $value && !is_scalar($value)) {
            $value = $this->serializer->normalize($value, $format, $context);
        }

        return $value;
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
