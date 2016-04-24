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
 * Class PaymentMethodAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait PaymentMethodAwareTrait
{
    protected $paymentMethod;

    public function getPaymentMethod() : PaymentMethodInterface
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethodInterface $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    public function hasPaymentMethod() : bool
    {
        return $this->paymentMethod instanceof PaymentMethodInterface;
    }
}
