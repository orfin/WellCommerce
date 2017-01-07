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

namespace WellCommerce\Bundle\NewsBundle\DataSet\Admin;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class NewsDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'        => 'news.id',
            'createdAt' => 'news.createdAt',
            'startDate' => 'news.startDate',
            'endDate'   => 'news.endDate',
            'topic'     => 'news_translation.topic',
            'summary'   => 'news_translation.summary',
            'content'   => 'news_translation.content',
            'slug'      => 'news_translation.slug',
            'locale'    => 'news_translation.locale',
            'route'     => 'IDENTITY(news_translation.route)',
            'publish'   => 'news.publish',
            'featured'  => 'news.featured',
            'photo'     => 'photos.path',
        ]);
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->leftJoin('news.translations', 'news_translation');
        $queryBuilder->leftJoin('news.photo', 'photos');
        $queryBuilder->groupBy('news.id');
        
        return $queryBuilder;
    }
}
