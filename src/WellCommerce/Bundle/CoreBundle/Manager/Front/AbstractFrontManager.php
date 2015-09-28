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

namespace WellCommerce\Bundle\CoreBundle\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;

/**
 * Class AbstractFrontManager
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFrontManager extends AbstractManager implements FrontManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getProviders()
    {
        return $this->get('resource.provider.collection');
    }

    /**
     * {@inheritdoc}
     */
    public function getProvider($type)
    {
        return $this->getProviders()->get($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryProvider()
    {
        return $this->getProvider('category');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductProvider()
    {
        return $this->getProvider('product');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStatusProvider()
    {
        return $this->getProvider('product_status');
    }

    /**
     * {@inheritdoc}
     */
    public function getCartProvider()
    {
        return $this->getProvider('cart');
    }

    /**
     * {@inheritdoc}
     */
    public function getCartProductProvider()
    {
        return $this->getProvider('cart_product');
    }

    /**
     * @return ShopContextInterface
     */
    public function getShopContext()
    {
        return $this->get('shop.context.front');
    }

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCurrentCart()
    {
        return $this->getCartProvider()->getCurrentCart();
    }
}
