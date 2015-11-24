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

namespace WellCommerce\AppBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyPathInterface;
use WellCommerce\AppBundle\Entity\MediaInterface;
use WellCommerce\AppBundle\Entity\Product;
use WellCommerce\AppBundle\Entity\ProductInterface;
use WellCommerce\AppBundle\Entity\ProductPhoto;

/**
 * Class ProductPhotoCollectionToArrayTransformer
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductPhotoCollectionToArrayTransformer extends MediaCollectionToArrayTransformer
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

        $collection = $this->createPhotosCollection($modelData, $values);

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
     * @param Collection $collection
     */
    protected function clearPreviousCollection(Collection $collection)
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
    protected function createPhotosCollection(Product $product, $values)
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
     * @return \WellCommerce\AppBundle\Entity\Media
     */
    protected function getMediaById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Returns product photo model
     *
     * @param MediaInterface   $media
     * @param ProductInterface $modelData
     * @param array            $values
     *
     * @return ProductPhoto
     */
    protected function getProductPhoto(MediaInterface $media, ProductInterface $modelData, $values)
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
     * @param MediaInterface $photo
     * @param int            $mainId
     *
     * @return bool
     */
    private function isMainPhoto(MediaInterface $photo, $mainId)
    {
        return $photo->getId() === (int)$mainId;
    }
}
