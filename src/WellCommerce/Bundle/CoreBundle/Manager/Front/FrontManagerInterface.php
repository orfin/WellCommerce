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

/**
 * Interface FrontManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FrontManagerInterface extends ManagerInterface
{
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

    /**
     * Shorthand to get cart products provider
     *
     * @return \WellCommerce\Bundle\CartBundle\Provider\CartProductProviderInterface
     */
    public function getCartProductProvider();

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\Cart
     */
    public function getCurrentCart();
}
