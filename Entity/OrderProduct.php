<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\VariantAwareTrait;

/**
 * Class OrderProduct
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProduct extends AbstractEntity implements OrderProductInterface
{
    use TimestampableTrait;
    use ProductAwareTrait;
    use VariantAwareTrait;
    use OrderAwareTrait;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var Price
     */
    protected $buyPrice;

    /**
     * @var Price
     */
    protected $sellPrice;

    /**
     * @var float
     */
    protected $weight;

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
    public function getSellPrice() : Price
    {
        return $this->sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setSellPrice(Price $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuyPrice() : Price
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
    public function getWeight() : float
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }
}
