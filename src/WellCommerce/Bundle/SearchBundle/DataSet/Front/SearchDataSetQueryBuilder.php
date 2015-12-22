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

namespace WellCommerce\Bundle\SearchBundle\DataSet\Front;

use Doctrine\ORM\Query\Expr;
use WellCommerce\Bundle\ProductBundle\DataSet\Front\ProductDataSetQueryBuilder;
use WellCommerce\Bundle\SearchBundle\Provider\SearchProviderInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchDataSetQueryBuilder extends ProductDataSetQueryBuilder
{
    /**
     * @var SearchProviderInterface
     */
    protected $provider;

    /**
     * @param SearchProviderInterface $provider
     */
    public function setSearchProvider(SearchProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $qb = parent::getQueryBuilder($columns, $request);
        $qb->setParameter('scores', $this->provider->getResultIdentifiers());

        return $qb;
    }
}
