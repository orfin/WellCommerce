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

namespace WellCommerce\Bundle\CatalogBundle\Manager\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\CatalogBundle\Entity\ProductInterface;

/**
 * Class ProductAttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttributeManager extends AbstractAdminManager
{
    /**
     * @var AttributeValueRepositoryInterface
     */
    protected $attributeValueRepository;

    /**
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     */
    public function setAttributeValueRepository(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function getAttributesCollectionForProduct(ProductInterface $product, array $values)
    {
        $values     = $this->filterValues($values);
        $collection = new ArrayCollection();

        foreach ($values as $id => $value) {
            $productAttribute = $this->getProductAttribute($id, $value);
            $productAttribute->setProduct($product);
            $collection->add($productAttribute);
        }

        return $collection;
    }

    /**
     * Creates an attribute
     *
     * @param int    $id
     * @param string $value
     *
     * @return \WellCommerce\Bundle\CatalogBundle\Entity\ProductAttributeInterface
     */
    protected function getProductAttribute($id, $value)
    {
        /** @var $productAttribute \WellCommerce\Bundle\CatalogBundle\Entity\ProductAttributeInterface */
        $productAttribute = $this->repository->find($id);
        if (null === $productAttribute) {
            $productAttribute = $this->initResource();
        }

        $productAttribute->setModifierType($value['suffix']);
        $productAttribute->setModifierValue($value['modifier']);
        $productAttribute->setStock($value['stock']);
        $productAttribute->setSymbol($value['symbol']);
        $productAttribute->setWeight($value['weight']);
        $productAttribute->setAttributeValues($this->makeAttributeValuesCollection($value['attributes']));

        return $productAttribute;
    }

    /**
     * Prepares collection from passed attribute values
     *
     * @param array $values
     *
     * @return ArrayCollection
     */
    protected function makeAttributeValuesCollection($values)
    {
        $collection = new ArrayCollection();
        foreach ($values as $id) {
            $item = $this->attributeValueRepository->find($id);
            if (null !== $item) {
                $collection->add($item);
            }
        }

        return $collection;
    }

    /**
     * Filters passed data and strips non-array values
     *
     * @param array $values
     *
     * @return array
     */
    private function filterValues($values)
    {
        return array_filter($values, function ($value) {
            return is_array($value);
        });
    }
}
