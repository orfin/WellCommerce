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

namespace WellCommerce\Bundle\ProductBundle\Form\Admin\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\Bundle\FormBundle\DataTransformer\DataTransformerInterface;
use WellCommerce\Bundle\MediaBundle\Entity\Media;
use WellCommerce\Bundle\MediaBundle\Form\Admin\DataTransformer\MediaCollectionToArrayTransformer;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto;

/**
 * Class ProductPhotoCollectionToArrayTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductPhotoCollectionToArrayTransformer extends MediaCollectionToArrayTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($modelData, PropertyPathInterface $propertyPath, $values)
    {
        if (!$modelData instanceof Product) {
            throw new \InvalidArgumentException(sprintf('Wrong entity passed "%s"', get_class($modelData)));
        }

        if ($this->isPhotoCollectionUnModified($values)) {
            return false;
        }

        $previousCollection = $this->propertyAccessor->getValue($modelData, $propertyPath);
        $this->clearPreviousCollection($previousCollection);

        $collection = $this->createPhotosCollection($modelData, $values, $previousCollection);

        if (0 === $collection->count()) {
            $modelData->setPhoto(null);
        }

        $this->propertyAccessor->setValue($modelData, $propertyPath, $collection);
    }

    /**
     * Checks whether photo collection was modified
     *
     * @param array $values
     *
     * @return bool
     */
    private function isPhotoCollectionUnModified($values)
    {
        return (isset($values['unmodified']) && (int)$values['unmodified'] === 1);
    }

    /**
     * Resets previous photo collection
     *
     * @param PersistentCollection $collection
     */
    protected function clearPreviousCollection(PersistentCollection $collection)
    {
        if ($collection->count()) {
            foreach ($collection as $item) {
                $collection->removeElement($item);
            }
        }
    }

    /**
     * Returns new photos collection
     *
     * @param Product $product
     * @param array   $values
     *
     * @return ArrayCollection
     */
    protected function createPhotosCollection(Product $product, $values, PersistentCollection $previousCollection)
    {
        $photos      = new ArrayCollection();
        $identifiers = $this->getMediaIdentifiers($values);

        foreach ($identifiers as $id) {
            $media = $this->getMediaById($id);
            $photo = $this->getProductPhoto($media, $product, $values);
            if (!$photos->contains($photo)) {
                $photos->add($photo);
            }
        }

        return $photos;
    }

    /**
     * Fetch only media identifiers from an array
     *
     * @param array $values
     *
     * @return array
     */
    private function getMediaIdentifiers($values)
    {
        $identifiers = [];

        foreach ($values as $key => $id) {
            if (is_int($key)) {
                $identifiers[] = $id;
            }
        }

        return $identifiers;
    }

    /**
     * Returns media entity by its identifier
     *
     * @param int $id
     *
     * @return \WellCommerce\Bundle\MediaBundle\Entity\Media
     */
    protected function getMediaById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Returns product photo model
     *
     * @param Media   $media
     * @param Product $modelData
     * @param array   $values
     *
     * @return ProductPhoto
     */
    protected function getProductPhoto(Media $media, Product $modelData, $values)
    {
        $mainPhoto    = $this->isMainPhoto($media, $values['main']);
        $productPhoto = new ProductPhoto();
        $productPhoto->setPhoto($media);
        $productPhoto->setMainPhoto($mainPhoto);
        $productPhoto->setProduct($modelData);

        if ($mainPhoto) {
            $modelData->setPhoto($media);
        }

        return $productPhoto;
    }

    /**
     * Checks whether photo was chosen as main product photo
     *
     * @param Media $photo
     * @param int   $mainId
     *
     * @return bool
     */
    private function isMainPhoto(Media $photo, $mainId)
    {
        return $photo->getId() === (int)$mainId;
    }
}
