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

namespace WellCommerce\Bundle\AppBundle\DataSet\Front;

use Doctrine\ORM\Query\Expr;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Bundle\AppBundle\Provider\ProductSearchProviderInterface;

/**
 * Class ProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSearchDataSetQueryBuilder extends ProductDataSetQueryBuilder
{
    /**
     * @var ProductSearchProviderInterface
     */
    protected $provider;

    /**
     * @param ProductSearchProviderInterface $provider
     */
    public function setProductSearchProvider(ProductSearchProviderInterface $provider)
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
