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

namespace WellCommerce\Bundle\CartBundle\Exception;


class AddCartItemException extends \RuntimeException
{
    /**
     * @param string $id
     */
    public function __construct($id)
    {
        parent::__construct(sprintf('Cannot add item with ID "%s" to cart', $id));
    }
}
