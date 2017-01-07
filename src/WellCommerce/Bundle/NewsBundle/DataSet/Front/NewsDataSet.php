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

namespace WellCommerce\Bundle\NewsBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\NewsBundle\DataSet\Admin\NewsDataSet as BaseDataSet;
use WellCommerce\Bundle\NewsBundle\Entity\News;
use WellCommerce\Bundle\NewsBundle\Entity\NewsTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class NewsDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        parent::configureOptions($configurator);
        
        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route'),
            'photo' => $this->getDataSetTransformer('image_path', ['filter' => 'original']),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            News::class,
            NewsTranslation::class,
        ]));
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->leftJoin('news.translations', 'news_translation');
        $queryBuilder->leftJoin('news.photo', 'photos');
        $queryBuilder->groupBy('news.id');
        $queryBuilder->andWhere($queryBuilder->expr()->eq('news.publish', true));
        
        return $queryBuilder;
    }
}
