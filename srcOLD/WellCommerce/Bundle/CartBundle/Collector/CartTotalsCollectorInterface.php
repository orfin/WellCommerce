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

namespace WellCommerce\Bundle\CartBundle\Collector;

use WellCommerce\Bundle\CartBundle\Entity\CartInterface;

/**
 * Interface CartTotalsCollectorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartTotalsCollectorInterface
{
    /**
     * Collects quantities
     *
     * @param CartInterface $cart
     *
     * @return int|float
     */
    public function collectTotalQuantity(CartInterface $cart);

    /**
     * Collects weights
     *
     * @param CartInterface $cart
     *
     * @return int|float
     */
    public function collectTotalWeight(CartInterface $cart);

    /**
     * Collects net amounts
     *
     * @param CartInterface $cart
     * @param null|string   $targetCurrency
     *
     * @return int|float
     */
    public function collectTotalNetAmount(CartInterface $cart, $targetCurrency = null);

    /**
     * Collects gross amounts
     *
     * @param CartInterface $cart
     * @param null|string   $targetCurrency
     *
     * @return int|float
     */
    public function collectTotalGrossAmount(CartInterface $cart, $targetCurrency = null);

    /**
     * Collects tax amounts
     *
     * @param CartInterface $cart
     * @param null|string   $targetCurrency
     *
     * @return int|float
     */
    public function collectTotalTaxAmount(CartInterface $cart, $targetCurrency = null);
}
