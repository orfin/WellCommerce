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

namespace WellCommerce\Bundle\CartBundle\DataSet\Front;

use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\AbstractDataSetQueryBuilder;
use WellCommerce\Bundle\DataSetBundle\QueryBuilder\QueryBuilderInterface;

/**
 * Class CartProductDataSetQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductDataSetQueryBuilder extends AbstractDataSetQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * Sets cart provider
     *
     * @param CartProviderInterface $cartHelper
     */
    public function setCartProvider(CartProviderInterface $cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder()
    {
        $cart         = $this->cartProvider->getCurrentCart();
        $queryBuilder = parent::getQueryBuilder();
        $expression   = $queryBuilder->expr()->eq('cart_product.cart', ':cart');

        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('cart', $cart->getId());

        return $queryBuilder;
    }
}
