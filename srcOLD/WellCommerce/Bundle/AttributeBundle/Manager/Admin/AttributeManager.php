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

namespace WellCommerce\Bundle\AttributeBundle\Manager\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueInterface;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeGroupRepositoryInterface;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractAdminManager
{
    /**
     * @var \WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface
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
     * @return ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function findAttributesByAttributeGroupId($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);
        if ($attributeGroup instanceof AttributeGroupInterface) {
            $criteria = new Criteria();
            $criteria->where($criteria->expr()->eq('attributeGroup', $attributeGroup));

            return $this->repository->matching($criteria);
        }

        return new ArrayCollection();
    }

    /**
     * Creates an attribute or returns the existing one
     *
     * @param int                     $id
     * @param string                  $name
     * @param AttributeGroupInterface $group
     *
     * @return AttributeInterface
     */
    public function getAttribute($id, $name, AttributeGroupInterface $group)
    {
        $attribute = $this->repository->find($id);
        if (null === $attribute) {
            $attribute = $this->createNewAttribute($name, $group);
        }

        return $attribute;
    }

    /**
     * Creates an attribute
     *
     * @param string                  $name
     * @param AttributeGroupInterface $group
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Entity\AttributeInterface
     */
    protected function createNewAttribute($name, AttributeGroupInterface $group)
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
