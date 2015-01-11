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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\AbstractDataTransformer;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformer\DataTransformerInterface;

/**
 * Class CollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaCollectionToArrayTransformer extends AbstractDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        if (null === $modelData || !$modelData instanceof PersistentCollection) {
            return;
        }

        $items = [];
        foreach ($modelData as $item) {
            if ($item->getMainPhoto() == 1) {
                $items['main_photo'] = $item->getPhoto()->getId();
            }
            $items['photos'][] = $item->getPhoto()->getId();
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        $collection = new ArrayCollection();

        foreach ($values as $key => $id) {
            if (is_int($key)) {
                $photo = $this->getRepository()->find($id);
                $collection->add($photo);
            }
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }
}
