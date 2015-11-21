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

use WellCommerce\CatalogBundle\Entity\AttributeInterface;
use WellCommerce\CatalogBundle\Exception\AttributeNotFoundException;
use WellCommerce\CatalogBundle\Repository\AttributeRepositoryInterface;
use WellCommerce\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeValueManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueManager extends AbstractAdminManager
{
    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function setAttributeRepository(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Adds new attributes value
     *
     * @param string $attributeValueName
     * @param int    $attributeId
     *
     * @return \WellCommerce\CatalogBundle\Entity\AttributeValueInterface
     */
    public function addAttributeValue($attributeValueName, $attributeId)
    {
        $attribute = $this->findAttribute($attributeId);
        $value     = $this->createAttributeValue($attributeValueName, $attribute);

        return $value;
    }

    /**
     * Returns attribute by id
     *
     * @param int $attributeId
     *
     * @return \WellCommerce\CatalogBundle\Entity\AttributeInterface
     */
    protected function findAttribute($attributeId)
    {
        $id        = $this->getRequestHelper()->getRequestBagParam('attribute');
        $attribute = $this->attributeRepository->find($id);

        if (null === $attribute) {
            throw new AttributeNotFoundException($attributeId);
        }

        return $attribute;
    }

    /**
     * Adds new value for attribute
     *
     * @param string             $name
     * @param AttributeInterface $attribute
     *
     *
     * @return \WellCommerce\CatalogBundle\Entity\AttributeValueInterface
     */
    protected function createAttributeValue($name, AttributeInterface $attribute)
    {
        $value = $this->initResource();

        foreach ($this->getLocales() as $locale) {
            $value->translate($locale->getCode())->setName($name);
        }

        $value->mergeNewTranslations();
        $value->setAttribute($attribute);

        $this->saveResource($value);

        return $value;
    }
}
