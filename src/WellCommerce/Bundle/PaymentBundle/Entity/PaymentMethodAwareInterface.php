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

namespace WellCommerce\Bundle\PaymentBundle\Entity;

/**
 * Interface PaymentMethodAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodAwareInterface
{
    public function getPaymentMethod() : PaymentMethodInterface;

    public function setPaymentMethod(PaymentMethodInterface $paymentMethod);

    public function hasPaymentMethod() : bool;
}
