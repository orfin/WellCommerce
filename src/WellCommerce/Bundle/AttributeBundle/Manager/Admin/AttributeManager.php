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

use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeManager extends AbstractAdminManager
{
    /**
     * @var AttributeGroupManager
     */
    protected $attributeGroupManager;

    /**
     * @param AttributeGroupManager $attributeGroupManager
     */
    public function setAttributeGroupManager(AttributeGroupManager $attributeGroupManager)
    {
        $this->attributeGroupManager = $attributeGroupManager;
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
        $group = $this->repository->find($set);

        return $group;
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
        $attribute = $this->factory->create();

        foreach ($this->getLocales() as $locale) {
            $attribute->translate($locale->getCode())->setName($name);
        }

        $attribute->mergeNewTranslations();

        $em->persist($attribute);
        $em->flush();

        return $attribute;
    }
}
