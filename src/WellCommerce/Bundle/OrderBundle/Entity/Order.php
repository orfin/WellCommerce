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
namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ClientBundle\Entity\ClientAwareTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopAwareTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodAwareTrait;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodAwareTrait;

/**
 * Class Order
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Order implements OrderInterface
{
    use TimestampableTrait;
    use ShopAwareTrait;
    use ShippingMethodAwareTrait;
    use PaymentMethodAwareTrait;
    use ClientAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @var Collection
     */
    protected $modifiers;

    /**
     * @var string
     */
    protected $sessionId;

    /**
     * @var OrderStatusInterface
     */
    protected $currentStatus;

    /**
     * @var AddressInterface
     */
    protected $billingAddress;

    /**
     * @var AddressInterface
     */
    protected $shippingAddress;
    
    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $comment;
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(OrderProductInterface $orderProduct)
    {
        $this->products->add($orderProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(OrderProductInterface $orderProduct)
    {
        $this->products->removeElement($orderProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(AddressInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingAddress(AddressInterface $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifiers(Collection $modifiers)
    {
        $this->modifiers = $modifiers;
    }

    /**
     * {@inheritdoc}
     */
    public function addModifier(OrderModifierInterface $orderModifier)
    {
        $this->modifiers->add($orderModifier);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentStatus(OrderStatusInterface $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * {@inheritdoc}
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
