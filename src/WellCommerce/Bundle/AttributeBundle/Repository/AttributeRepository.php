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
            ->addOrderBy('attribute_translation.name', 'ASC');

        $query  = $qb->getQuery();
        $result = $query->getArrayResult();

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
}
