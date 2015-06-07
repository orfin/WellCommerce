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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;

/**
 * Class Order
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\OrderBundle\Repository\OrderRepository")
 */
class Order
{
    use TimestampableTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\OrderProduct", mappedBy="order", cascade={"persist"})
     */
    protected $products;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\OrderModifier", mappedBy="order", cascade={"persist"})
     */
    protected $modifiers;

    /**
     * @var float
     *
     * @ORM\Column(name="session_id", type="string", nullable=false)
     */
    protected $sessionId;

    /**
     * @ORM\OneToOne(targetEntity="WellCommerce\Bundle\ClientBundle\Entity\Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod")
     * @ORM\JoinColumn(name="payment_method_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     */
    protected $paymentMethod;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\OrderStatus")
     * @ORM\JoinColumn(name="order_status_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $currentStatus;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod")
     * @ORM\JoinColumn(name="shipping_method_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     */
    protected $shippingMethod;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Shop")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    protected $shop;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Address", columnPrefix = "billing_address_")
     */
    protected $billingAddress;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Address", columnPrefix = "shipping_address_")
     */
    protected $shippingAddress;
    
    /**
     * @ORM\Column(type="string", nullable=false, length=16)
     */
    protected $currency;

    /**
     * @ORM\Column(type="string", nullable=false, length=1000)
     */
    protected $comment;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->modifiers  = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param float $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @param OrderProduct $orderProduct
     */
    public function addProduct(OrderProduct $orderProduct)
    {
        $this->products->add($orderProduct);
    }

    /**
     * @param OrderProduct $orderProduct
     */
    public function removeProduct(OrderProduct $orderProduct)
    {
        $this->products->removeElement($orderProduct);
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param null|Client $client
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;
    }

    /**
     * @return Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     */
    public function setShop(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param mixed $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return null|ShippingMethod
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param mixed $shippingMethod
     */
    public function setShippingMethod(ShippingMethod $shippingMethod = null)
    {
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * @return ArrayCollection|\WellCommerce\Bundle\OrderBundle\Entity\OrderProduct[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param mixed $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param mixed $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return ArrayCollection|\WellCommerce\Bundle\OrderBundle\Entity\OrderModifier[]
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * @param ArrayCollection $modifiers
     */
    public function setModifiers(ArrayCollection $modifiers)
    {
        $this->modifiers = $modifiers;
    }

    /**
     * @param OrderModifier $orderModifier
     */
    public function addModifier(OrderModifier $orderModifier)
    {
        $this->modifiers->add($orderModifier);
    }

    /**
     * @return OrderStatus
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param OrderStatus $currentStatus
     */
    public function setCurrentStatus(OrderStatus $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
