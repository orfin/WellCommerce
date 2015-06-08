<?php

namespace WellCommerce\Bundle\CartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="cart_product")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CartBundle\Repository\CartProductRepository")
 */
class CartProduct
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
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CartBundle\Entity\Cart", inversedBy="products")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $cart;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    protected $attribute;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=15, scale=4)
     */
    protected $quantity;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return null|ProductAttribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param null|ProductAttribute $attribute
     */
    public function setAttribute(ProductAttribute $attribute = null)
    {
        $this->attribute = $attribute;
    }


    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = (int)$quantity;
    }

    public function increaseQuantity($increase)
    {
        $this->quantity += (int)$increase;
    }

    public function decreaseQuantity($decrease)
    {
        $this->quantity -= (int)$decrease;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    protected function recalculateCartTotals()
    {
        $this->getCart()->recalculateCartTotals();
    }
}
