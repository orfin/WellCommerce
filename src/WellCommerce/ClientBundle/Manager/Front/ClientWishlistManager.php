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

namespace WellCommerce\ClientBundle\Manager\Front;

use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\AppBundle\Manager\Front\AbstractFrontManager;

/**
 * Class ClientWishlistManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistManager extends AbstractFrontManager
{
    public function addProductToWishlist(ProductInterface $product)
    {
        $client   = $this->getClient();
        $wishlist = $this->findWishlist($product);

        if (null === $wishlist) {
            $wishlist = $this->factory->create();
            $wishlist->setClient($client);
            $wishlist->setProduct($product);
            $this->createResource($wishlist);
        }
    }

    public function deleteProductFromWishlist(ProductInterface $product)
    {
        $wishlist = $this->findWishlist($product);

        if (null !== $wishlist) {
            $this->removeResource($wishlist);
        }
    }

    public function findWishlist(ProductInterface $product)
    {
        $client = $this->getClient();

        return $this->repository->findOneBy([
            'client'  => $client,
            'product' => $product
        ]);
    }
}
