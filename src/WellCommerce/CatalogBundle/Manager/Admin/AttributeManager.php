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

namespace WellCommerce\CatalogBundle\Manager\Admin;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\CatalogBundle\Entity\Attribute\GroupInterface;
use WellCommerce\CatalogBundle\Entity\AttributeInterface;
use WellCommerce\CatalogBundle\Entity\AttributeValueInterface;
use WellCommerce\CatalogBundle\Exception\AttributeGroupNotFoundException;
use WellCommerce\CatalogBundle\Repository\AttributeGroupRepositoryInterface;
use WellCommerce\CatalogBundle\Repository\AttributeValueRepositoryInterface;
use WellCommerce\AppBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractAdminManager
{
    /**
     * @var \WellCommerce\CatalogBundle\Repository\AttributeRepositoryInterface
     */
    protected $repository;

    /**
     * @var AttributeGroupRepositoryInterface
     */
    protected $attributeGroupRepository;

    /**
     * @var AttributeValueRepositoryInterface
     */
    protected $attributeValueRepository;

    /**
     * @param AttributeGroupRepositoryInterface $attributeGroupRepository
     */
    public function setAttributeGroupRepository(AttributeGroupRepositoryInterface $attributeGroupRepository)
    {
        $this->attributeGroupRepository = $attributeGroupRepository;
    }

    /**
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     */
    public function setAttributeValueRepository(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @return AttributeInterface
     */
    public function createAttribute($attributeName, $attributeGroupId)
    {
        $attributeGroup = $this->findAttributeGroup($attributeGroupId);

        return $this->createNewAttribute($attributeName, $attributeGroup);
    }

    public function getAttributeSet($attributeGroupId)
    {
        $attributesCollection = $this->findAttributesByAttributeGroupId($attributeGroupId);
        $sets                 = [];

        $attributesCollection->map(function (AttributeInterface $attribute) use (&$sets) {
            $sets[] = [
                'id'     => $attribute->getId(),
                'name'   => $attribute->translate()->getName(),
                'values' => $this->getAttributeValuesSet($attribute)
            ];
        });

        return $sets;
    }

    /**
     * Returns all attribute's values as array
     *
     * @param AttributeInterface $attribute
     *
     * @return array
     */
    protected function getAttributeValuesSet(AttributeInterface $attribute)
    {
        $attributeValuesCollection = $this->attributeValueRepository->getCollectionByAttribute($attribute);
        $values                    = [];
        $attributeValuesCollection->map(function (AttributeValueInterface $attributeValue) use (&$values) {
            $values[] = [
                'id'   => $attributeValue->getId(),
                'name' => $attributeValue->translate()->getName()
            ];
        });

        return $values;
    }

    /**
     * Returns all attributes in group
     *
     * @param int $id
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findAttributesByAttributeGroupId($id)
    {
        $attributeGroup = $this->findAttributeGroup($id);
        $criteria       = new Criteria();
        $criteria->where($criteria->expr()->eq('attributeGroup', $attributeGroup));

        return $this->repository->matching($criteria);
    }

    /**
     * Returns an attribute's group or throws an exception
     *
     * @param int $id
     *
     * @return GroupInterface
     */
    protected function findAttributeGroup($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);
        if (null === $attributeGroup) {
            throw new AttributeGroupNotFoundException($id);
        }

        return $attributeGroup;
    }

    /**
     * Creates an attribute
     *
     * @param string         $name
     * @param GroupInterface $group
     *
     * @return \WellCommerce\CatalogBundle\Entity\AttributeInterface
     */
    protected function createNewAttribute($name, GroupInterface $group)
    {
        $attribute = $this->initResource();
        $attribute->setAttributeGroup($group);

        foreach ($this->getLocales() as $locale) {
            $attribute->translate($locale->getCode())->setName($name);
        }

        $attribute->mergeNewTranslations();

        $this->saveResource($attribute);

        return $attribute;
    }
}
