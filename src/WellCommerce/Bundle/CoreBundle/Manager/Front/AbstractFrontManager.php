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

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\AbstractManager;

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
    public function getResourceProviders()
    {
        return $this->get('resource.provider.collection');
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceProvider($type)
    {
        return $this->getResourceProviders()->get($type);
    }

    /**
     * {@inheritdoc}
     */
    public function getShopContext()
    {
        return $this->get('shop.context.front');
    }

    /**
     * {@inheritdoc}
     */
    public function getCartProvider()
    {
        return $this->getResourceProvider('cart');
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryProvider()
    {
        return $this->getResourceProvider('category');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductProvider()
    {
        return $this->getResourceProvider('product');
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStatusProvider()
    {
        return $this->getResourceProvider('product_status');
    }

    /**
     * {@inheritdoc}
     */
    public function getProducerProvider()
    {
        return $this->getResourceProvider('producer');
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCart()
    {
        return $this->getCartProvider()->getResource();
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        $user = $this->getUser();

        if ($user instanceof ClientInterface) {
            return $user;
        }

        return null;
    }
}
