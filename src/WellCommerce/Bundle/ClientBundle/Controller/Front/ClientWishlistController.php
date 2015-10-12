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

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ClientWishlistController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistController extends AbstractFrontController implements FrontControllerInterface
{
    public function indexAction()
    {
        return $this->displayTemplate('index');
    }

    public function addAction(ProductInterface $product){

    }
}
