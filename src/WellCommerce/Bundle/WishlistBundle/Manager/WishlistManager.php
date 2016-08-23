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

namespace WellCommerce\Bundle\WishlistBundle\Manager;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\WishlistBundle\Entity\WishlistInterface;

/**
 * Class WishlistManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class WishlistManager extends AbstractManager
{
    public function addProductToWishlist(ProductInterface $product, ClientInterface $client)
    {
        $wishlist = $this->findWishlist($product, $client);
        
        if (!$wishlist instanceof WishlistInterface) {
            /** @var WishlistInterface $wishlist */
            $wishlist = $this->initResource();
            $wishlist->setClient($client);
            $wishlist->setProduct($product);
            $this->createResource($wishlist);
        }
    }
    
    public function deleteProductFromWishlist(ProductInterface $product, ClientInterface $client)
    {
        $wishlist = $this->findWishlist($product, $client);
        
        if ($wishlist instanceof WishlistInterface) {
            $this->removeResource($wishlist);
        }
    }
    
    private function findWishlist(ProductInterface $product, ClientInterface $client)
    {
        return $this->getRepository()->findOneBy([
            'client'  => $client,
            'product' => $product
        ]);
    }
}
