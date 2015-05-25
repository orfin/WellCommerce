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

    public function addAction()
    {
        /**
         * @var $manager \WellCommerce\Bundle\CartBundle\Manager\Front\CartManager
         */
        $manager   = $this->getManager();
        $product   = $manager->findProduct();
        $attribute = $manager->findProductAttribute($product);
        $quantity  = $manager->getRequestHelper()->getRequestAttribute('id', 1);

        $manager->addItem($product, $attribute, $quantity);

        return [
            'product' => $product
        ];
    }
}
