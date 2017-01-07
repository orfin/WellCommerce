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

namespace WellCommerce\Bundle\PageBundle\DataSet\Front;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Bundle\PageBundle\DataSet\Admin\PageDataSet as BaseDataSet;
use WellCommerce\Bundle\PageBundle\Entity\Page;
use WellCommerce\Bundle\PageBundle\Entity\PageTranslation;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class PageDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataSet extends BaseDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        parent::configureOptions($configurator);
        
        $configurator->setColumnTransformers([
            'route' => $this->getDataSetTransformer('route'),
        ]);
        
        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
            Page::class,
            PageTranslation::class,
        ]));
    }
    
    protected function createQueryBuilder(): QueryBuilder
    {
        $queryBuilder = $this->repository->getQueryBuilder();
        $queryBuilder->leftJoin('page.translations', 'page_translation');
        $queryBuilder->leftJoin('page.children', 'page_children');
        $queryBuilder->leftJoin('page.shops', 'page_shops');
        $queryBuilder->groupBy('page.id');
        $queryBuilder->where('page.publish = :publish');
        $queryBuilder->setParameter('publish', true);
        
        return $queryBuilder;
    }
}
