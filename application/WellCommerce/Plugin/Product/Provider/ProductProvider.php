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

namespace WellCommerce\Plugin\Product\Provider;

use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Plugin\Product\Model\Product;

/**
 * Class ProductProvider
 *
 * @package WellCommerce\Plugin\Product\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductProvider extends AbstractComponent
{
    /**
     * Current product data
     *
     * @var
     */
    private $data;

    /**
     * Sets product model for currently viewed product
     *
     * @param Product $product
     */
    public function setCurrent(Product $product)
    {
        $this->data = $product;
    }

    /**
     * Returns normalized product data
     *
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->data;
    }
} 