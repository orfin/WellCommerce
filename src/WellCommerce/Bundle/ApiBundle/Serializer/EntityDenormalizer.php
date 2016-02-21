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

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use WellCommerce\Bundle\ApiBundle\Metadata\Collection\FieldMetadataCollection;

/**
 * Class EntityDenormalizer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityDenormalizer extends AbstractSerializer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $resource              = $context['resource'];
        $serializationMetadata = $this->getSerializationMetadata($resource);
        $serializedFields      = $serializationMetadata->getFields();

        $this->updateEntityFields($data, $serializedFields, $resource);

        return $resource;
    }

    /**
     * Updates the resource fields with given data
     *
     * @param array                   $properties
     * @param FieldMetadataCollection $collection
     * @param object                  $resource
     */
    protected function updateEntityFields(array $properties, FieldMetadataCollection $collection, $resource)
    {
        foreach ($properties as $propertyName => $propertyValue) {
            if ($collection->has($propertyName) && is_scalar($propertyValue)) {
                if ($this->propertyAccessor->isWritable($resource, $propertyName)) {
                    $this->propertyAccessor->setValue($resource, $propertyName, $propertyValue);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return is_array($data) && $this->doctrineHelper->getMetadataFactory()->hasMetadataFor($type);
    }
}
