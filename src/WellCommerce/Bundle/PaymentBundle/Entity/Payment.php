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

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\OrderBundle\Entity\OrderAwareTrait;

/**
 * Class PaymentMethod
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Payment implements PaymentInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use OrderAwareTrait;
    
    /**
     * @var string
     */
    protected $processor;
    
    /**
     * @var array
     */
    protected $configuration = [];
    
    /**
     * @var string
     */
    protected $state = PaymentInterface::PAYMENT_STATE_CREATED;
    
    /**
     * @var string
     */
    protected $token;
    
    /**
     * @var string
     */
    protected $externalToken;
    
    /**
     * @var string|null
     */
    protected $externalIdentifier;
    
    /**
     * @var string
     */
    protected $redirectUrl;
    
    /**
     * @var string
     */
    protected $comment = '';
    
    /**
     * {@inheritdoc}
     */
    public function getProcessor(): string
    {
        return $this->processor;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setProcessor(string $processor)
    {
        $this->processor = $processor;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getToken(): string
    {
        return $this->token;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExternalIdentifier()
    {
        return $this->externalIdentifier;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExternalIdentifier($identifier)
    {
        $this->externalIdentifier = $identifier;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function getExternalToken()
    {
        return $this->externalToken;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExternalToken($externalToken)
    {
        $this->externalToken = $externalToken;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isCreated(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_CREATED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreated()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_CREATED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isApproved(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_APPROVED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setApproved()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_APPROVED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isFailed(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_FAILED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFailed()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_FAILED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isCancelled(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_CANCELLED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCancelled()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_CANCELLED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isExpired(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_EXPIRED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExpired()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_EXPIRED;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isPending(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_PENDING;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setPending()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_PENDING;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isInProgress(): bool
    {
        return $this->state === PaymentInterface::PAYMENT_STATE_IN_PROGRESS;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setInProgress()
    {
        $this->state = PaymentInterface::PAYMENT_STATE_IN_PROGRESS;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getState(): string
    {
        return $this->state;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getComment(): string
    {
        return $this->comment;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
}
