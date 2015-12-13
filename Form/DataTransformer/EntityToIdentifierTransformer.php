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

namespace WellCommerce\Bundle\CoreBundle\Form\DataTransformer;

use Symfony\Component\PropertyAccess\PropertyPathInterface;

/**
 * Class EntityToIdentifierTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class EntityToIdentifierTransformer extends AbstractDataTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        if (null === $modelData) {
            return 0;
        }

        $meta       = $this->getRepository()->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();

        return $this->propertyAccessor->getValue($modelData, $identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        if (null !== $value) {
            $entity = $this->getRepository()->find($value);
            $this->propertyAccessor->setValue($modelData, $propertyPath, $entity);
        }
    }
}
