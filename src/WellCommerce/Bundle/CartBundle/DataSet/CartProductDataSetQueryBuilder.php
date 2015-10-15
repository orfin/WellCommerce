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

namespace WellCommerce\Bundle\CartBundle\DataSet;

use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\DataSetQueryBuilderInterface;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequestInterface;

/**
 * Class CartProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements DataSetQueryBuilderInterface
{
    /**
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * Constructor
     *
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param CartProviderInterface          $cartProvider
     */
    public function __construct(CartProductRepositoryInterface $cartProductRepository, CartProviderInterface $cartProvider)
    {
        parent::__construct($cartProductRepository);
        $this->cartProvider = $cartProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $queryBuilder = parent::getQueryBuilder($columns, $request);
        $expression   = $queryBuilder->expr()->eq('cart_product.cart', ':cart');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('cart', $this->cartProvider->getResourceIdentifier());
        $queryBuilder->setParameter('date', new \DateTime());

        return $queryBuilder;
    }
}
