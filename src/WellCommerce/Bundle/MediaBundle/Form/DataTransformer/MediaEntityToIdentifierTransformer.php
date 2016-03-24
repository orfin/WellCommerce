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
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\EntityToIdentifierTransformer;

/**
 * Class MediaEntityToIdentifierTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaEntityToIdentifierTransformer extends EntityToIdentifierTransformer
{
    /**
     * Transforms identifier to entity
     *
     * @param object                $modelData
     * @param PropertyPathInterface $propertyPath
     * @param mixed                 $value
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $value)
    {
        $item = null;
        if (isset($value[0])) {
            $id   = $value[0];
            $item = $this->getRepository()->find($id);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $item);
    }
}
