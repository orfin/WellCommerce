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

namespace WellCommerce\Bundle\CartBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartProduct;
use WellCommerce\Bundle\CoreBundle\Controller\Front\AbstractFrontController;
use WellCommerce\Bundle\CoreBundle\Controller\Front\FrontControllerInterface;

/**
 * Class CartController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template()
 */
class CartController extends AbstractFrontController implements FrontControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {

    }

    public function addAction(Request $request)
    {
        $product     = $this->get('product.repository')->find(51);
        $cart        = new Cart();
        $cartProduct = new CartProduct();
        $cartProduct->setQuantity(1);
        $cartProduct->setProduct($product);
        $cartProduct->setCart($cart);

        $cart->addProduct($cartProduct);
        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();
        die();
    }
}
