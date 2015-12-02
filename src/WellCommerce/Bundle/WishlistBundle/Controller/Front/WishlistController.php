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

namespace WellCommerce\Bundle\AppBundle\Controller\Front;

use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;

/**
 * Class WishlistController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WishlistController extends AbstractFrontController
{
    /**
     * @var \WellCommerce\Bundle\AppBundle\Manager\Front\WishlistManager
     */
    protected $manager;

    public function indexAction()
    {
        return $this->displayTemplate('index');
    }

    public function addAction(ProductInterface $product)
    {
        $this->manager->addProductToWishlist($product);

        return $this->redirectToAction('index');
    }

    public function deleteAction(ProductInterface $product)
    {
        $this->manager->deleteProductFromWishlist($product);

        return $this->redirectToAction('index');
    }
}
