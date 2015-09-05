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
use WellCommerce\Bundle\ClientBundle\Entity\ClientTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\AddressInterface;
use WellCommerce\Bundle\CoreBundle\Entity\ContactDetailsTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopTrait;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethodTrait;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodTrait;

/**
 * Class Cart
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CartBundle\Repository\CartRepository")
 */
class Cart implements CartInterface
{
    use TimestampableTrait;
    use ShopTrait;
    use ShippingMethodTrait;
    use PaymentMethodTrait;
    use ClientTrait;
    use ContactDetailsTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\CartBundle\Entity\CartProduct", mappedBy="cart", cascade={"persist"})
     */
    protected $products;

    /**
     * @ORM\Column(name="session_id", type="string", nullable=false)
     */
    protected $sessionId;

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
    public function addProduct(CartProduct $cartProduct)
    {
        $this->products->add($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(CartProduct $cartProduct)
    {
        $this->products->removeElement($cartProduct);
    }

    /**
     * {@inheritdoc}
     */
    public function getTotals()
    {
        return $this->totals;
    }

    /**
     * {@inheritdoc}
     */
    public function setTotals(CartTotalsInterface $cartTotals)
    {
        $this->totals = $cartTotals;
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
    public function setProducts(ArrayCollection $products)
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
    public function isEmpty()
    {
        return 0 === $this->products->count();
    }
}
