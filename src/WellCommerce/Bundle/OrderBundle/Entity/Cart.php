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
namespace WellCommerce\Bundle\OrderBundle\Entity;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Cart extends Order implements CartInterface
{
    /**
     * @var bool
     */
    protected $copyAddress;
    
    public function getCopyAddress() : bool
    {
        return $this->copyAddress;
    }
    
    public function setCopyAddress(bool $copyAddress)
    {
        $this->copyAddress = $copyAddress;
    }
    
    public function isEmpty() : bool
    {
        return 0 === $this->productTotal->getQuantity();
    }
}
