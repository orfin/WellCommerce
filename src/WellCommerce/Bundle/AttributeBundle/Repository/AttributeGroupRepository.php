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
namespace WellCommerce\Bundle\AttributeBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;

/**
 * Class AttributeGroupRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupRepository extends EntityRepository implements AttributeGroupRepositoryInterface
{
    public function getAttributeGroupSet() : array
    {
        $groups = $this->matching(new Criteria());
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
