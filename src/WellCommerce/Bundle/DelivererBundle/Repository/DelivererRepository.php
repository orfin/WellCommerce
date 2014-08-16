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
namespace WellCommerce\Bundle\DelivererBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class DelivererRepository
 *
 * @package WellCommerce\Bundle\DelivererBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererRepository extends AbstractEntityRepository implements DelivererRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('deliverer.id')
            ->leftJoin(
                'WellCommerce\Bundle\DelivererBundle\Entity\DelivererTranslation',
                'deliverer_translation',
                'WITH',
                'deliverer.id = deliverer_translation.translatable AND deliverer_translation.locale = :locale');

    }
}
