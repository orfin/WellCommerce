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

namespace WellCommerce\Bundle\ShippingBundle\Options;

/**
 * Interface ShippingOptionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingOptionInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return float
     */
    public function getTaxAmount();

    /**
     * @return float
     */
    public function getNetPrice();

    /**
     * @return float
     */
    public function getGrossPrice();
}
