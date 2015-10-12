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
     * @return \WellCommerce\Bundle\CoreBundle\Provider\ResourceProviderCollection
     */
    public function getResourceProviders();

    /**
     * Returns single provider by type
     *
     * @param string $alias
     *
     * @return \WellCommerce\Bundle\CoreBundle\Provider\ResourceProviderInterface
     */
    public function getResourceProvider($alias);

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartInterface
     */
    public function getCurrentCart();
}
