<?php

namespace WellCommerce\SalesBundle\Entity;

use WellCommerce\CatalogBundle\Entity\ProductAttributeAwareTrait;
use WellCommerce\CatalogBundle\Entity\ProductAwareTrait;
use WellCommerce\AppBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;
use WellCommerce\AppBundle\Entity\Price;

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
    public function setSellPrice(Price $sellPrice)
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
