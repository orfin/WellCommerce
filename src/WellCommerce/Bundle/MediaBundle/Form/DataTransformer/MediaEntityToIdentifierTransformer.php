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

namespace WellCommerce\Bundle\MediaBundle\Form\DataTransformer;

use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\AbstractDataTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface;

/**
 * Class MediaEntityToIdentifierTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaEntityToIdentifierTransformer extends AbstractDataTransformer implements DataTransformerInterface
{
    /**
     * Transforms entity to primary key identifier
     *
     * @param $entity
     *
     * @return int|mixed
     */
    public function transform($entity)
    {
        if (null == $entity) {
            return 0;
        }

        $meta       = $this->getRepository()->getMetadata();
        $identifier = $meta->getSingleIdentifierFieldName();

        return $this->propertyAccessor->getValue($entity, $identifier);
    }

    /**
     * Transforms identifier to entity
     *
     * @param $id
     *
     * @return mixed
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $item = null;
        if (isset($data[0])) {
            $id   = $data[0];
            $item = $this->getRepository()->find($id);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $item);
    }
} 