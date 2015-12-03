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

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;

/**
 * Interface PaymentMethodInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface, HierarchyAwareInterface
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

    /**
     * @return Collection
     */
    public function getShippingMethods();

    /**
     * @param Collection $shippingMethods
     */
    public function setShippingMethods(Collection $shippingMethods);

    /**
     * @return OrderStatusInterface
     */
    public function getDefaultOrderStatus();

    /**
     * @param OrderStatusInterface $defaultOrderStatus
     */
    public function setDefaultOrderStatus(OrderStatusInterface $defaultOrderStatus);

    /**
     * @return Collection
     */
    public function getConfiguration();

    /**
     * @param Collection $configuration
     */
    public function setConfiguration(Collection $configuration);
}
