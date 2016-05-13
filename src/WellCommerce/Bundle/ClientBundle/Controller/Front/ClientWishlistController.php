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

namespace WellCommerce\Bundle\ClientBundle\Controller\Front;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\ClientBundle\Manager\ClientWishlistManager;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ClientWishlistController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistController extends AbstractFrontController
{
    public function indexAction() : Response
    {
        return $this->displayTemplate('index');
    }
    
    public function addAction(ProductInterface $product) : RedirectResponse
    {
        $this->getManager()->addProductToWishlist(
            $product,
            $this->getAuthenticatedClient()
        );

        return $this->redirectToAction('index');
    }

    public function deleteAction(ProductInterface $product) : RedirectResponse
    {
        $this->getManager()->deleteProductFromWishlist(
            $product,
            $this->getAuthenticatedClient()
        );

        return $this->redirectToAction('index');
    }

    protected function getManager() : ClientWishlistManager
    {
        return parent::getManager();
    }
}
