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

namespace WellCommerce\AppBundle\Manager\Admin;

use WellCommerce\AppBundle\Entity\AttributeInterface;
use WellCommerce\AppBundle\Exception\AttributeNotFoundException;
use WellCommerce\AppBundle\Repository\AttributeRepositoryInterface;
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
     * @return \WellCommerce\AppBundle\Entity\AttributeValueInterface
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
     * @return \WellCommerce\AppBundle\Entity\AttributeInterface
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
     * @return \WellCommerce\AppBundle\Entity\AttributeValueInterface
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
