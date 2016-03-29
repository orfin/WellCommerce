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

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderAwareInterface;

/**
 * Class PaymentInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentInterface extends EntityInterface, TimestampableInterface, OrderAwareInterface
{
    const PAYMENT_STATE_CREATED     = 'created';
    const PAYMENT_STATE_APPROVED    = 'approved';
    const PAYMENT_STATE_FAILED      = 'failed';
    const PAYMENT_STATE_CANCELLED   = 'canceled';
    const PAYMENT_STATE_EXPIRED     = 'expired';
    const PAYMENT_STATE_PENDING     = 'pending';
    const PAYMENT_STATE_IN_PROGRESS = 'in_progress';

    /**
     * @return string
     */
    public function getProcessor() : string;

    /**
     * @param string $processor
     */
    public function setProcessor(string $processor);

    /**
     * @return string
     */
    public function getToken() : string;

    /**
     * @param string $token
     */
    public function setToken(string $token);

    /**
     * @return array
     */
    public function getConfiguration() : array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);

    /**
     * @return array
     */
    public function getApprovalUrl() : string;

    /**
     * @param array $approvalUrl
     */
    public function setApprovalUrl(string $approvalUrl);

    /**
     * @return string
     */
    public function getState() : string;

    /**
     * @param string $state
     */
    public function setState(string $state);

    /**
     * @return bool
     */
    public function isCreated() : bool;

    /**
     * @return bool
     */
    public function isApproved() : bool;

    /**
     * @return bool
     */
    public function isFailed() : bool;

    /**
     * @return bool
     */
    public function isCancelled() : bool;

    /**
     * @return bool
     */
    public function isExpired() : bool;

    /**
     * @return bool
     */
    public function isPending() : bool;

    /**
     * @return bool
     */
    public function isInProgress() : bool;
}
