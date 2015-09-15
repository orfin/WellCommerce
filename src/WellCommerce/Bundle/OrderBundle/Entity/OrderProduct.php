<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class CartProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="orders_product")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\OrderBundle\Repository\OrderProductRepository")
 */
class OrderProduct
{
    use TimestampableTrait;
    use ProductAwareTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\Order", inversedBy="products")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=true, onDelete="RESTRICT")
     */
    protected $attribute;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=15, scale=4)
     */
    protected $quantity;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Price", columnPrefix = "net_price_")
     */
    protected $netPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="tax_value", type="decimal", precision=15, scale=4)
     */
    protected $taxValue;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Price", columnPrefix = "gross_price_")
     */
    protected $grossPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    protected $weight;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $cart
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * @param mixed $netPrice
     */
    public function setNetPrice($netPrice)
    {
        $this->netPrice = $netPrice;
    }

    /**
     * @return float
     */
    public function getTaxValue()
    {
        return $this->taxValue;
    }

    /**
     * @param float $taxValue
     */
    public function setTaxValue($taxValue)
    {
        $this->taxValue = $taxValue;
    }

    /**
     * @return mixed
     */
    public function getGrossPrice()
    {
        return $this->grossPrice;
    }

    /**
     * @param mixed $grossPrice
     */
    public function setGrossPrice($grossPrice)
    {
        $this->grossPrice = $grossPrice;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
