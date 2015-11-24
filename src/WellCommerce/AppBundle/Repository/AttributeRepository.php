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
namespace WellCommerce\AppBundle\Repository;

use Doctrine\Common\Collections\Criteria;
use WellCommerce\AppBundle\Entity\Attribute\GroupInterface;
use WellCommerce\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractEntityRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCollectionByAttributeGroup(GroupInterface $attributeGroup)
    {
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->eq('attributeGroup', $attributeGroup));

        return $this->matching($criteria);
    }
}
