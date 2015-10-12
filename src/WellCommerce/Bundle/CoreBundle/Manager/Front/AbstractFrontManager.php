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
     * @return ShopContextInterface
     */
    public function getShopContext()
    {
        return $this->get('shop.context.front');
    }

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartInterface
     */
    public function getCurrentCart()
    {
        return $this->getResourceProvider('cart')->getCurrentResource();
    }
}
