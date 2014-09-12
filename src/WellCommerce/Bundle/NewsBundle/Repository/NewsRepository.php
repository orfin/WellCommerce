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
namespace WellCommerce\Bundle\NewsBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;

/**
 * Class UnitRepository
 *
 * @package WellCommerce\Bundle\UnitBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsRepository extends AbstractEntityRepository implements NewsRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataGridQueryBuilder()
    {
        return parent::getQueryBuilder()->groupBy('news.id')
            ->leftJoin(
                'WellCommerce\Bundle\NewsBundle\Entity\NewsTranslation',
                'news_translation',
                'WITH',
                'news.id = news_translation.translatable AND news_translation.locale = :locale');

    }
}
