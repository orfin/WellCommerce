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
 * Interface PaymentMethodInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * Returns payment method processor
     *
     * @return string
     */
    public function getProcessor();

    /**
     * Sets payment method processor
     *
     * @param string $processor
     */
    public function setProcessor($processor);
}
