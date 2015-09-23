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

use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;
use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepositoryInterface;
use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;

/**
 * Class AttributeValueManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueManager extends AbstractAdminManager
{
    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * @var AttributeRepositoryInterface
     */
    protected $attributeRepository;

    /**
     * Constructor
     *
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     * @param AttributeRepositoryInterface      $attributeRepository
     * @param LocaleRepositoryInterface         $localeRepository
     */
    public function __construct(
        AttributeValueRepositoryInterface $attributeValueRepository,
        AttributeRepositoryInterface $attributeRepository,
        LocaleRepositoryInterface $localeRepository
    ) {
        parent::__construct($attributeValueRepository);
        $this->attributeRepository = $attributeRepository;
        $this->localeRepository    = $localeRepository;
    }

    /**
     * Adds new attribute value
     *
     * @param Attribute $attribute
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue
     */
    public function addAttributeValue()
    {
        $attribute = $this->findAttribute();
        $name      = $this->getRequestHelper()->getRequestAttribute('name');
        $value     = $this->createAttributeValue($attribute, $name);

        return $value;
    }

    /**
     * Returns attribute found by its identifier
     *
     * @return null|\WellCommerce\Bundle\AttributeBundle\Entity\Attribute
     */
    protected function findAttribute()
    {
        $id        = $this->getRequestHelper()->getRequestAttribute('attribute');
        $attribute = $this->attributeRepository->find($id);

        if (null === $attribute) {
            throw new \InvalidArgumentException('Attribute was not found.');
        }

        return $attribute;
    }

    /**
     * Adds new value for attribute
     *
     * @param Attribute $attribute
     * @param string    $name
     *
     * @return AttributeValue
     */
    protected function createAttributeValue(Attribute $attribute, $name)
    {
        $entityManager = $this->getDoctrineHelper()->getEntityManager();
        $value         = new AttributeValue();

        foreach ($this->localeRepository->findAll() as $locale) {
            $value->translate($locale->getCode())->setName($name);
        }

        $value->mergeNewTranslations();
        $value->setAttribute($attribute);

        $entityManager->persist($value);
        $entityManager->flush();

        return $value;
    }
}
