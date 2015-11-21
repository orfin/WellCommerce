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

namespace WellCommerce\ClientBundle\Controller\Front;

use WellCommerce\CatalogBundle\Entity\ProductInterface;
use WellCommerce\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class ClientWishlistController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * @var \WellCommerce\ClientBundle\Manager\Front\ClientWishlistManager
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
