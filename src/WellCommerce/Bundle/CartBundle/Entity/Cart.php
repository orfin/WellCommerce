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
namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\ClientBundle\Entity\Client;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CartBundle\Repository\CartRepository")
 */
class Cart
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
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\CartBundle\Entity\CartProduct", mappedBy="cart", cascade={"persist"})
     */
    protected $products;

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
     * @ORM\JoinColumn(name="payment_method_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $paymentMethod;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethod")
     * @ORM\JoinColumn(name="shipping_method_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $shippingMethod;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Shop")
     * @ORM\JoinColumn(name="shop_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $shop;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CartBundle\Entity\CartTotals", columnPrefix = "total_")
     */
    protected $totals;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Address", columnPrefix = "billing_address_")
     */
    protected $billingAddress;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Address", columnPrefix = "shipping_address_")
     */
    protected $shippingAddress;
    
    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\ContactDetails", columnPrefix = "contact_details_")
     */
    protected $contactDetails;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->totals   = new CartTotals();
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
     * @param CartProduct $cartProduct
     */
    public function addProduct(CartProduct $cartProduct)
    {
        $this->products->add($cartProduct);
    }

    public function removeProduct(CartProduct $cartProduct)
    {
        $this->products->removeElement($cartProduct);
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
     * @return CartTotals
     */
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * @param CartTotals $cartTotals
     */
    public function setTotals(CartTotals $cartTotals)
    {
        $this->totals = $cartTotals;
    }

    /**
     * @return ArrayCollection|\WellCommerce\Bundle\CartBundle\Entity\CartProduct[]
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
     * @return mixed
     */
    public function getContactDetails()
    {
        return $this->contactDetails;
    }

    /**
     * @param mixed $contactDetails
     */
    public function setContactDetails($contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->products->count() === 0;
    }
}
