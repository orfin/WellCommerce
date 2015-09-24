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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderProductTotals
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductTotals implements OrderProductTotalsInterface
{
    /**
     * @var float
     */
    protected $quantity = 0;

    /**
     * @var float
     */
    protected $weight = 0;

    /**
     * @var float
     */
    protected $grossAmount = 0;

    /**
     * @var float
     */
    protected $netAmount = 0;

    /**
     * @var float
     */
    protected $taxAmount = 0;

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
        $this->quantity = $quantity;
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

    /**
     * {@inheritdoc}
     */
    public function getGrossAmount()
    {
        return $this->grossAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function setGrossAmount($grossAmount)
    {
        $this->grossAmount = $grossAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function getNetAmount()
    {
        return $this->netAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function setNetAmount($netAmount)
    {
        $this->netAmount = $netAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
    }
}
