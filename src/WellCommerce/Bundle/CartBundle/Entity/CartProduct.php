<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProduct extends AbstractEntity implements CartProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;
    use VariantAwareTrait;

    /**
     * @var CartInterface
     */
    protected $cart;

    /**
     * @var float
     */
    protected $quantity;

    /**
     * {@inheritdoc}
     */
    public function getQuantity() : int
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function increaseQuantity(int $increase)
    {
        $this->quantity += $increase;
    }

    /**
     * {@inheritdoc}
     */
    public function decreaseQuantity(int $decrease)
    {
        $this->quantity -= $decrease;
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
    public function getSellPrice() : DiscountablePrice
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant->getSellPrice();
        }

        return $this->product->getSellPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight() : float
    {
        if ($this->variant instanceof VariantInterface) {
            return $this->variant->getWeight();
        }

        return $this->product->getWeight();
    }
}
