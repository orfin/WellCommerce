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
use WellCommerce\AppBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeGroupManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupManager extends AbstractAdminManager
{
    /**
     * Creates a new attributes group
     *
     * @param $name
     *
     * @return GroupInterface
     */
    public function createGroup($name)
    {
        $resource = $this->initResource();

        foreach ($this->getLocales() as $locale) {
            $resource->translate($locale->getCode())->setName($name);
        }

        $resource->mergeNewTranslations();
        $this->createResource($resource);

        return $resource;
    }

    /**
     * Returns all attribute groups as a collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupsCollection()
    {
        return $this->getRepository()->matching(new Criteria());
    }

    /**
     * Returns an array of all attribute groups
     *
     * @return array
     */
    public function getAttributeGroupSet()
    {
        $groups = $this->getGroupsCollection();
        $sets   = [];

        $groups->map(function (GroupInterface $attributeGroup) use (&$sets) {
            $sets[] = [
                'id'               => $attributeGroup->getId(),
                'name'             => $attributeGroup->translate()->getName(),
                'current_category' => false,
            ];
        });

        return $sets;
    }
}
