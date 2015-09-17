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

use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

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
    public function findAll()
    {
        $qb = $this->getQueryBuilder()
            ->addSelect('attribute.id, attribute_translation.name')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeTranslation',
                'attribute_translation',
                'WITH',
                'attribute.id = attribute_translation.translatable')
            ->addOrderBy('attribute_translation.name', 'ASC')
            ->addGroupBy('attribute.id');

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();
        foreach ($result as $key => $attribute) {
            $result[$key]['values'] = $this->getAttributeValueRepository()->findAllByAttributeId($attribute['id']);
        }

        return $result;
    }

    /**
     * Returns attribute value repository
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepository
     */
    private function getAttributeValueRepository()
    {
        return $this->getRepository('WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue');
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByAttributeGroupId($id)
    {
        $qb = $this->getQueryBuilder()
            ->addSelect('attribute.id, attribute_translation.name')
            ->join('attribute.groups', 'ag')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeTranslation',
                'attribute_translation',
                'WITH',
                'attribute.id = attribute_translation.translatable')
            ->addOrderBy('attribute_translation.name', 'ASC')
            ->addGroupBy('attribute.id');

        // filter by attribute id
        $qb->add('where', $qb->expr()->eq('ag.id', ':groups'));
        $qb->setParameter('groups', [$id]);

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();
        foreach ($result as $key => $attribute) {
            $result[$key]['values'] = $this->getAttributeValueRepository()->findAllByAttributeId($attribute['id']);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrCreate($data)
    {
        $accessor = $this->getPropertyAccessor();
        $id       = $accessor->getValue($data, '[id]');
        $name     = $accessor->getValue($data, '[name]');
        $values   = $accessor->getValue($data, '[values]');
        $isNew    = substr($id, 0, 3) == 'new';

        if ($isNew) {
            $item = $this->addAttribute($name);
        } else {
            $item = $this->find($id);
        }

        if (!empty($values)) {
            $collection = $this->getAttributeValueRepository()->makeCollection($item, $values);
            $item->setValues($collection);
        }

        return $item;
    }
}
