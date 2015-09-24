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

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
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
    public function getQueryBuilder()
    {
        $queryBuilder = parent::getQueryBuilder();
        $expression   = $queryBuilder->expr()->eq('cart_product.cart', ':cart');
        $queryBuilder->andWhere($expression);
        $queryBuilder->setParameter('cart', $this->getCartIdentifier());
        $queryBuilder->setParameter('date', new \DateTime());

        return $queryBuilder;
    }

    protected function getCartIdentifier()
    {
        if ($this->cartProvider->getCurrentCart() instanceof CartInterface) {
            return $this->cartProvider->getCurrentCart()->getId();
        }

        return 0;
    }
}
