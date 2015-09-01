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

use WellCommerce\Bundle\AdminBundle\Manager\AbstractAdminManager;
use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeGroupRepositoryInterface;
use WellCommerce\Bundle\AttributeBundle\Repository\AttributeRepositoryInterface;
use WellCommerce\Bundle\IntlBundle\Repository\LocaleRepositoryInterface;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractAdminManager
{
    /**
     * @var AttributeGroupRepositoryInterface
     */
    protected $attributeGroupRepository;

    /**
     * @var LocaleRepositoryInterface
     */
    protected $localeRepository;

    /**
     * Constructor
     *
     * @param AttributeRepositoryInterface      $attributeRepository
     * @param AttributeGroupRepositoryInterface $attributeGroupRepository
     * @param LocaleRepositoryInterface         $localeRepository
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        AttributeGroupRepositoryInterface $attributeGroupRepository,
        LocaleRepositoryInterface $localeRepository
    ) {
        parent::__construct($attributeRepository);
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->localeRepository         = $localeRepository;
    }

    /**
     * @return Attribute
     */
    public function createAttribute()
    {
        $attributeGroup = $this->findAttributeGroup();
        $attributeName  = $this->getRequestHelper()->getRequestAttribute('name');

        return $this->createNewAttribute($attributeGroup, $attributeName);
    }

    /**
     * @return null|AttributeGroup
     */
    protected function findAttributeGroup()
    {
        $set   = (int)$this->getRequestHelper()->getRequestAttribute('set');
        $group = $this->attributeGroupRepository->find($set);

        return $group;
    }

    /**
     * @return \WellCommerce\Bundle\IntlBundle\Entity\Locale[]
     */
    protected function getLocales()
    {
        return $this->localeRepository->findAll();
    }

    /**
     * Creates
     *
     * @param AttributeGroup $group
     * @param string         $name
     *
     * @return Attribute
     */
    protected function createNewAttribute(AttributeGroup $group, $name)
    {
        $em        = $this->getDoctrineHelper()->getEntityManager();
        $attribute = new Attribute();
        $attribute->addGroup($group);

        foreach ($this->localeRepository->findAll() as $locale) {
            $attribute->translate($locale->getCode())->setName($name);
        }

        $attribute->mergeNewTranslations();

        $em->persist($attribute);
        $em->flush();

        return $attribute;
    }
}
