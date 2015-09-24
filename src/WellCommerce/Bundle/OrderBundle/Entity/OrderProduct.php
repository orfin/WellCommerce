<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Entity\Price;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;

/**
 * Class OrderProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProduct implements OrderProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;
    use ProductAttributeAwareTrait;
    use OrderAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $quantity;

    /**
     * @var Price
     */
    protected $buyPrice;

    /**
     * @var DiscountablePrice
     */
    protected $sellPrice;

    /**
     * @var float
     */
    protected $weight;

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
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setSellPrice(DiscountablePrice $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setBuyPrice(Price $buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
