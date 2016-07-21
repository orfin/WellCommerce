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

use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface PaymentStateHistoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentStateHistoryInterface extends EntityInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @param PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment);

    /**
     * @return PaymentInterface
     */
    public function getPayment() : PaymentInterface;

    /**
     * @return string
     */
    public function getState() : string;

    /**
     * @param string $state
     */
    public function setState(string $state);

    /**
     * @return string
     */
    public function getComment() : string;

    /**
     * @param string $comment
     */
    public function setComment(string $comment);
}
