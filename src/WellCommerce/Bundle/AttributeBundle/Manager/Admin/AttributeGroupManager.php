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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Admin\AbstractAdminManager;

/**
 * Class AttributeGroupManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupManager extends AbstractAdminManager
{
    public function createAttributeGroup(string $name) : AttributeGroupInterface
    {
        $group = $this->initResource();

        foreach ($this->getLocales() as $locale) {
            $group->translate($locale->getCode())->setName($name);
        }

        $group->mergeNewTranslations();
        $this->createResource($group);

        return $group;
    }

    public function getAttributeGroupsCollection() : Collection
    {
        return $this->getRepository()->matching(new Criteria());
    }

    public function getAttributeGroupSet() : array
    {
        $groups = $this->getAttributeGroupsCollection();
        $sets   = [];

        $groups->map(function (AttributeGroupInterface $attributeGroup) use (&$sets) {
            $sets[] = [
                'id'               => $attributeGroup->getId(),
                'name'             => $attributeGroup->translate()->getName(),
                'current_category' => false,
            ];
        });

        return $sets;
    }
}
