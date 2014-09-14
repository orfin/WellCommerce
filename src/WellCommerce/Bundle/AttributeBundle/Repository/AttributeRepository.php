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
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeRepository
 *
 * @package WellCommerce\Bundle\AttributeBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeRepository extends AbstractEntityRepository implements AttributeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $qb = parent::getQueryBuilder()
            ->addSelect('attribute.id, attribute_translation.name')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeTranslation',
                'attribute_translation',
                'WITH',
                'attribute.id = attribute_translation.translatable AND attribute_translation.locale = :locale')
            ->setParameter('locale', $this->getCurrentLocale())
            ->addOrderBy('attribute_translation.name', 'ASC')
            ->addGroupBy('attribute.id');

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();
        foreach($result as $key => $attribute){
            $result[$key]['values'] = $this->getAttributeValueRepository()->findAllByAttributeId($attribute['id']);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttribute($name)
    {
        $locales   = $this->getLocales();
        $attribute = new Attribute();

        foreach ($locales as $locale) {
            $attribute->translate($locale->getCode())->setName($name);
        }
        $attribute->mergeNewTranslations();
        $this->getEntityManager()->persist($attribute);

        return $attribute;
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

    /**
     * Returns attribute value repository
     *
     * @return \WellCommerce\Bundle\AttributeBundle\Repository\AttributeValueRepository
     */
    private function getAttributeValueRepository()
    {
        return $this->getRepository('WellCommerce\Bundle\AttributeBundle\Entity\AttributeValue');
    }
}
