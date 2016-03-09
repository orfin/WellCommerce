<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProduct implements CartProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var CartInterface
     */
    protected $cart;

    /**
     * @var ProductAttributeInterface
     */
    protected $attribute;

    /**
     * @var float
     */
    protected $quantity;

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
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute(ProductAttributeInterface $attribute = null)
    {
        $this->attribute = $attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        $this->quantity = abs((int)$quantity);
    }

    /**
     * {@inheritdoc}
     */
    public function increaseQuantity($increase)
    {
        $this->quantity += abs((int)$increase);
    }

    /**
     * {@inheritdoc}
     */
    public function decreaseQuantity($decrease)
    {
        $this->quantity -= abs((int)$decrease);
    }

    /**
     * {@inheritdoc}
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * {@inheritdoc}
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellPrice()
    {
        if (null === $this->attribute) {
            return $this->product->getSellPrice();
        }

        return $this->attribute->getSellPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        if (null === $this->attribute) {
            return $this->product->getWeight();
        }

        return $this->attribute->getWeight();
    }
}
