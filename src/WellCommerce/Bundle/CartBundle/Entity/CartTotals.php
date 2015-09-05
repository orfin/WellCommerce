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
 * Class CartTotals
 *
 * @ORM\Embeddable
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartTotals implements CartTotalsInterface
{
    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=15, scale=4)
     */
    protected $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    protected $weight;

    /**
     * @var float
     *
     * @ORM\Column(name="net_price", type="decimal", precision=15, scale=4)
     */
    protected $netPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="gross_price", type="decimal", precision=15, scale=4)
     */
    protected $grossPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="tax_amount", type="decimal", precision=15, scale=4)
     */
    protected $taxAmount;

    /**
     * Constructor
     *
     * @param int $quantity
     * @param int $weight
     * @param int $netPrice
     * @param int $grossPrice
     * @param int $taxAmount
     */
    public function __construct($quantity = 0, $weight = 0, $netPrice = 0, $grossPrice = 0, $taxAmount = 0)
    {
        $this->quantity   = $quantity;
        $this->weight     = $weight;
        $this->netPrice   = $netPrice;
        $this->grossPrice = $grossPrice;
        $this->taxAmount  = $taxAmount;
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
    public function getNetPrice()
    {
        return $this->netPrice;
    }

    /**
     * @param float $netPrice
     */
    public function setNetPrice($netPrice)
    {
        $this->netPrice = (float)$netPrice;
    }

    /**
     * @return float
     */
    public function getGrossPrice()
    {
        return $this->grossPrice;
    }

    /**
     * @param float $grossPrice
     */
    public function setGrossPrice($grossPrice)
    {
        $this->grossPrice = (float)$grossPrice;
    }

    /**
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @param float $taxAmount
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = (float)$taxAmount;
    }
}
