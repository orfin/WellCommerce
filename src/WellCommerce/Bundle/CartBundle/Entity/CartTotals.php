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

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Dimension
 *
 * @ORM\Embeddable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotals
{
    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=15, scale=4)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    private $weight;

    /**
     * @var float
     *
     * @ORM\Column(name="price_net", type="decimal", precision=15, scale=4)
     */
    private $priceNet;

    /**
     * @var float
     *
     * @ORM\Column(name="price_gross", type="decimal", precision=15, scale=4)
     */
    private $priceGross;

    /**
     * Constructor
     *
     * @param float $quantity
     * @param float $weight
     * @param float $priceNet
     * @param float $priceGross
     */
    public function __construct($quantity = 0, $weight = 0, $priceNet = 0, $priceGross = 0)
    {
        $this->quantity   = $quantity;
        $this->weight     = $weight;
        $this->priceNet   = $priceNet;
        $this->priceGross = $priceGross;
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
        $this->quantity = $quantity;
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

    /**
     * @return float
     */
    public function getPriceNet()
    {
        return $this->priceNet;
    }

    /**
     * @param float $priceNet
     */
    public function setPriceNet($priceNet)
    {
        $this->priceNet = $priceNet;
    }

    /**
     * @return float
     */
    public function getPriceGross()
    {
        return $this->priceGross;
    }

    /**
     * @param float $priceGross
     */
    public function setPriceGross($priceGross)
    {
        $this->priceGross = $priceGross;
    }
}
