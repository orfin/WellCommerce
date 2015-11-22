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

namespace WellCommerce\AppBundle\DataSet\Front;

use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Component\DataSet\QueryBuilder\DataSetQueryBuilderInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\AppBundle\Context\Front\CartContextInterface;
use WellCommerce\AppBundle\Repository\CartProductRepositoryInterface;

/**
 * Class CartProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements DataSetQueryBuilderInterface
{
    /**
     * @var CartContextInterface
     */
    protected $cartContext;

    /**
     * Constructor
     *
     * @param CartProductRepositoryInterface $cartProductRepository
     * @param CartContextInterface           $cartContext
     */
    public function __construct(CartProductRepositoryInterface $cartProductRepository, CartContextInterface $cartContext)
    {
        parent::__construct($cartProductRepository);
        $this->cartContext = $cartContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request)
    {
        $queryBuilder = parent::getQueryBuilder($columns, $request);
        $expression   = $queryBuilder->expr()->eq('cart_product.cart', ':cart');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('cart', $this->cartContext->getCurrentCartIdentifier());
        $queryBuilder->setParameter('date', new \DateTime());

        return $queryBuilder;
    }
}
