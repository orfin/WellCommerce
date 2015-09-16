<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

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
        $this->quantity = (int)$quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function increaseQuantity($increase)
    {
        $this->quantity += (int)$increase;
    }

    /**
     * {@inheritdoc}
     */
    public function decreaseQuantity($decrease)
    {
        $this->quantity -= (int)$decrease;
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
}
