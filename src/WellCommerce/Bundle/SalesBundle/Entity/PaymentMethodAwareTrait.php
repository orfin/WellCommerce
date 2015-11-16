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

namespace WellCommerce\Bundle\SalesBundle\Entity;

/**
 * Class PaymentMethodAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait PaymentMethodAwareTrait
{
    /**
     * @var PaymentMethodInterface
     */
    protected $paymentMethod;

    /**
     * @return null|PaymentMethodInterface
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param null|PaymentMethodInterface $paymentMethod
     */
    public function setPaymentMethod(PaymentMethodInterface $paymentMethod = null)
    {
        $this->paymentMethod = $paymentMethod;
    }
}
