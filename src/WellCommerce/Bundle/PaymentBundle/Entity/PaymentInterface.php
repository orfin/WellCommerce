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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
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
     * @return array
     */
    public function getConfiguration() : array;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration);

    /**
     * @return string
     */
    public function getToken() : string;

    /**
     * @param string $token
     */
    public function setToken(string $token);

    /**
     * {@inheritdoc}
     */
    public function getExternalToken();
    
    /**
     * {@inheritdoc}
     */
    public function setExternalToken($externalToken);

    /**
     * @return string|null
     */
    public function getExternalIdentifier();

    /**
     * @param string|null $identifier
     */
    public function setExternalIdentifier($identifier);

    /**
     * @return string|null
     */
    public function getRedirectUrl();

    /**
     * @param string|null $redirectUrl
     */
    public function setRedirectUrl($redirectUrl);

    /**
     * @return bool
     */
    public function isCreated() : bool;
    
    /**
     * @return void
     */
    public function setCreated ();
    
    /**
     * @return bool
     */
    public function isApproved() : bool;
    
    /**
     * @return void
     */
    public function setApproved ();
    
    /**
     * @return bool
     */
    public function isFailed() : bool;
    
    /**
     * @return void
     */
    public function setFailed ();
    
    /**
     * @return bool
     */
    public function isCancelled() : bool;
    
    /**
     * @return void
     */
    public function setCancelled ();
    
    /**
     * @return bool
     */
    public function isExpired() : bool;
    
    /**
     * @return void
     */
    public function setExpired ();
    
    /**
     * @return bool
     */
    public function isPending() : bool;
    
    /**
     * @return void
     */
    public function setPending ();
        
    /**
     * @return bool
     */
    public function isInProgress() : bool;
    
    /**
     * @return void
     */
    public function setInProgress ();
    
    /**
     * @return string
     */
    public function getState () : string;
    
    /**
     * @return string
     */
    public function getComment() : string;

    /**
     * @param string $comment
     */
    public function setComment(string $comment);
}
