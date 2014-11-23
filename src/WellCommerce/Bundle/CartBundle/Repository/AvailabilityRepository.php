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
namespace WellCommerce\Bundle\CartBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class CartRepository
 *
 * @package WellCommerce\Bundle\CartBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartRepository extends AbstractEntityRepository implements CartRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        $qb = parent::getQueryBuilder()->groupBy('availability.id');
        $qb->leftJoin(
            'WellCommerce\Bundle\CartBundle\Entity\CartTranslation',
            'availability_translation',
            'WITH',
            'availability.id = availability_translation.translatable AND availability_translation.locale = :locale');

        return $qb;

    }
}
