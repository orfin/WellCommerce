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

namespace WellCommerce\Bundle\WishlistBundle\Controller\Front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\WishlistBundle\Manager\WishlistManager;

/**
 * Class WishlistController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class WishlistController extends AbstractFrontController
{
    public function addAction(ProductInterface $product) : RedirectResponse
    {
        $this->getManager()->addProductToWishlist(
            $product,
            $this->getSecurityHelper()->getCurrentClient()
        );

        return $this->redirectToAction('index');
    }

    public function deleteAction(ProductInterface $product) : RedirectResponse
    {
        $this->getManager()->deleteProductFromWishlist(
            $product,
            $this->getSecurityHelper()->getCurrentClient()
        );

        return $this->redirectToAction('index');
    }
    
    protected function getManager() : WishlistManager
    {
        return parent::getManager();
    }
}
