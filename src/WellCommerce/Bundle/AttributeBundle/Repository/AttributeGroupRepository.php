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

use Symfony\Component\HttpFoundation\ParameterBag;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class AttributeGroupRepository
 *
 * @package WellCommerce\Bundle\AttributeBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AttributeGroupRepository extends AbstractEntityRepository implements AttributeGroupRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $qb = parent::getQueryBuilder()
            ->addSelect('attribute_group.id, attribute_group_translation.name')
            ->leftJoin(
                'WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupTranslation',
                'attribute_group_translation',
                'WITH',
                'attribute_group.id = attribute_group_translation.translatable AND attribute_group_translation.locale = :locale')
            ->setParameter('locale', $this->getCurrentLocale())
            ->addOrderBy('attribute_group_translation.name', 'ASC');

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function addAttributeGroup(ParameterBag $parameters)
    {
        $name    = $parameters->get('name');
        $locales = $this->getLocales();
        $group   = new AttributeGroup();

        foreach ($locales as $locale) {
            $group->translate($locale->getCode())->setName($name);
        }
        $group->mergeNewTranslations();
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();

        return $group;
    }
}
