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

namespace WellCommerce\Bundle\CartBundle\Repository;

use Doctrine\ORM\Query\Expr;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Repository\AbstractEntityRepository;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Class CartProductRepository
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductRepository extends AbstractEntityRepository implements CartProductRepositoryInterface
{
    public function getDataSetQueryBuilder()
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->groupBy('cart_product.id');
        $queryBuilder->leftJoin('cart_product.product', 'product');
        $queryBuilder->leftJoin('product.translations', 'product_translation');
        $queryBuilder->leftJoin('product.productPhotos', 'gallery', Expr\Join::WITH, 'gallery.mainPhoto = :mainPhoto');
        $queryBuilder->leftJoin('gallery.photo', 'photos');
        $queryBuilder->setParameter('mainPhoto', 1);


        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function findProductInCart(Cart $cart, Product $product, ProductAttribute $attribute = null)
    {
        return $this->findOneBy([
            'cart'      => $cart,
            'product'   => $product,
            'attribute' => $attribute
        ]);
    }
}
