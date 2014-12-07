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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AttributeBundle\Entity\Attribute;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeValueRepository
 *
 * @package WellCommerce\Bundle\AttributeBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeValueRepository extends AbstractEntityRepository implements AttributeValueRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $qb = parent::getQueryBuilder()
            ->addSelect('attribute_group.id, attribute_value_translation.name')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueTranslation',
                'attribute_value_translation',
                'WITH',
                'attribute_group.id = attribute_value_translation.translatable')
            ->addOrderBy('attribute_value_translation.name', 'ASC');

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByAttributeId($id)
    {
        $qb = parent::getQueryBuilder()
            ->addSelect('attribute_value.id, attribute_value_translation.name')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeValueTranslation',
                'attribute_value_translation',
                'WITH',
                'attribute_value.id = attribute_value_translation.translatable')
            ->addOrderBy('attribute_value_translation.name', 'ASC');
        $qb->addGroupBy('attribute_value.attribute');
        // filter by attribute id
        $where = $qb->expr()->eq('attribute_value.attribute', ':attribute');
        $qb->setParameter('attribute', $id);
        $qb->add('where', $where);

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();

        return $result;
    }

    public function makeCollection(Attribute $attribute, $values)
    {
        $accessor   = $this->getPropertyAccessor();
        $collection = new ArrayCollection();

        foreach ($values as $value) {
            $id    = $accessor->getValue($value, '[id]');
            $name  = $accessor->getValue($value, '[name]');
            $isNew = substr($id, 0, 3) == 'new';
            if ($isNew) {
                $item = $this->addAttributeValue($attribute, $name);
            } else {
                $item = $this->find($id);
            }

            $collection->add($item);
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeValue(Attribute $attribute, $name)
    {
        $locales = $this->getLocales();
        $value   = new AttributeValue();

        foreach ($locales as $locale) {
            $value->translate($locale->getCode())->setName($name);
        }
        $value->mergeNewTranslations();
        $value->setAttribute($attribute);

        $this->getEntityManager()->persist($value);

        return $value;
    }
}
