<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\OrderBundle\Calculator;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Interface OrderProductTotalCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductTotalCalculatorInterface
{
    public function getTotalQuantity (OrderInterface $order) : int;
    
    public function getTotalWeight (OrderInterface $order) : float;
    
    public function getTotalNetAmount (OrderInterface $order) : float;
    
    public function getTotalGrossAmount (OrderInterface $order) : float;
    
    public function getTotalTaxAmount (OrderInterface $order) : float;
}