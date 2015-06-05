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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface CartProductProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProductProviderInterface extends ProviderInterface
{
    /**
     * Shorthand for retrieving cart products
     *
     * @return array
     */
    public function getProducts();

    /**
     * Returns cart summary information
     *
     * @return array
     */
    public function getSummary();
}
