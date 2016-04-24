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

namespace WellCommerce\Bundle\ShippingBundle\Calculator\Adapter;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingSubjectInterface;

/**
 * Class ProductAdapter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductContext implements ShippingSubjectInterface
{
    /**
     * @var CartInterface
     */
    protected $product;

    /**
     * ProductAdapter constructor.
     *
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function getQuantity() : int
    {
        return 1;
    }
    
    public function getWeight() : float
    {
        return $this->product->getWeight();
    }
    
    public function getGrossPrice() : float
    {
        return $this->product->getSellPrice()->getGrossAmount();
    }
    
    public function getCurrency() : string
    {
        return $this->product->getSellPrice()->getCurrency();
    }
}
