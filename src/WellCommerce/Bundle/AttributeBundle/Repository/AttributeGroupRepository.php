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

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeGroupRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupRepository extends AbstractEntityRepository implements AttributeGroupRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->addSelect('attribute_group.id, attribute_group_translation.name');
        $queryBuilder->leftJoin(
            'WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupTranslation',
            'attribute_group_translation',
            'WITH',
            'attribute_group.id = attribute_group_translation.translatable');
        $queryBuilder->addOrderBy('attribute_group_translation.name', 'ASC');

        $query  = $queryBuilder->getQuery();
        $result = $query->getArrayResult();

        return $result;
    }
}
