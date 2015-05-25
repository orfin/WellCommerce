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

namespace WellCommerce\Bundle\CartBundle\Helper;

/**
 * Interface CartProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartProviderInterface
{
    public function getCart();
}