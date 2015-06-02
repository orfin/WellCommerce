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

use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\CoreBundle\Provider\ProviderCollection;
use WellCommerce\Bundle\MultiStoreBundle\Context\ShopContextInterface;

/**
 * Interface FrontManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
    /**
     * Sets providers collection
     *
     * @param ProviderCollection $providers
     */
    public function setProviders(ProviderCollection $providers);

    /**
     * Returns providers collection
     *
     * @return ProviderCollection
     */
    public function getProviders();

    /**
     * Returns single provider by type
     *
     * @param $type
     *
     * @return \WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface
     */
    public function getProvider($type);

    /**
     * @param ShopContextInterface $shopContext
     */
    public function setShopContext(ShopContextInterface $shopContext);

    /**
     * Shorthand to get category provider
     *
     * @return \WellCommerce\Bundle\CategoryBundle\Provider\CategoryProviderInterface
     */
    public function getCategoryProvider();

    /**
     * Shorthand to get product provider
     *
     * @return \WellCommerce\Bundle\ProductBundle\Provider\ProductProviderInterface
     */
    public function getProductProvider();

    /**
     * Shorthand to get product status provider
     *
     * @return \WellCommerce\Bundle\ProductBundle\Provider\ProductStatusProviderInterface
     */
    public function getProductStatusProvider();

    /**
     * Shorthand to get cart provider
     *
     * @return \WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface
     */
    public function getCartProvider();
}
