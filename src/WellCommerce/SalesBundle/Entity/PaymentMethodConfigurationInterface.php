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

namespace WellCommerce\SalesBundle\Entity;

use WellCommerce\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ShippingMethodCostInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodConfigurationInterface extends TimestampableInterface, PaymentMethodAwareInterface
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
     * @param string $name
     */
    public function setName($name);

    /**
     * @return bool|int|string
     */
    public function getValue();

    /**
     * @param bool|int|string $value
     */
    public function setValue($value);
}
