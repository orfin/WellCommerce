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
        print_r($this->getMetadata());
        die();

        $currentLevel = isset($context['level']) ? $context['level'] : 0;
        $data         = [];
        $metadata     = $this->getEntityMetadata($object);

        $this->updateDataFromFields($data, $metadata, $object);

        if (0 === $currentLevel) {
            $this->updateDataFromAssociations($data, $metadata, $object, $format, ['level' => 1]);
        }

        return $data;
    }

    /**
     * Updates normalized data with entity fields values
     *
     * @param array         $data
     * @param ClassMetadata $metadata
     * @param object        $object
     */
    protected function updateDataFromFields(array &$data = [], ClassMetadata $metadata, $object)
    {
        foreach ($metadata->getFieldNames() as $fieldName) {
            $propertyPath = $this->getPropertyPath($fieldName);
            $value        = $this->propertyAccessor->getValue($object, $fieldName);
            $this->propertyAccessor->setValue($data, $propertyPath, $value);
        }
    }

    /**
     * Updates normalized data with entity associations values
     *
     * @param array         $data
     * @param ClassMetadata $metadata
     * @param object        $object
     * @param string|null   $format
     * @param array         $context
     */
    protected function updateDataFromAssociations(array &$data = [], ClassMetadata $metadata, $object, $format = null, array $context = [])
    {
        foreach ($metadata->getAssociationNames() as $associationName) {
            $propertyPath = $this->getPropertyPath($associationName);
            $value        = $this->getAssociationValue($object, $associationName, $format, $context);
            $this->propertyAccessor->setValue($data, $propertyPath, $value);
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
