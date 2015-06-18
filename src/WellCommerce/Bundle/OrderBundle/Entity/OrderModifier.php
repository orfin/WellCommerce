<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;

/**
 * Class OrderModifier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="orders_modifier")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\OrderBundle\Repository\OrderModifierRepository")
 */
class OrderModifier
{
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\OrderBundle\Entity\Order", inversedBy="modifiers")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $order;

    /**
     * @ORM\Column(name="net_value", type="decimal", precision=15, scale=4, nullable=false)
     */
    protected $netValue;

    /**
     * @ORM\Column(name="tax_value", type="decimal", precision=15, scale=4, nullable=false)
     */
    protected $taxValue;

    /**
     * @ORM\Column(name="gross_value", type="decimal", precision=15, scale=4, nullable=false)
     */
    protected $grossValue;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_increase", type="boolean", nullable=false)
     */
    protected $increase;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\OrderBundle\Entity\OrderModifierDetails", columnPrefix = "modifier_detalils_")
     */
    protected $modifierDetails;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return float
     */
    public function getNetValue()
    {
        return $this->netValue;
    }

    /**
     * @param float $netValue
     */
    public function setNetValue($netValue)
    {
        $this->netValue = $netValue;
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
     * @return float
     */
    public function getGrossValue()
    {
        return $this->grossValue;
    }

    /**
     * @param float $grossValue
     */
    public function setGrossValue($grossValue)
    {
        $this->grossValue = $grossValue;
    }

    /**
     * @return bool
     */
    public function isIncrease()
    {
        return $this->increase;
    }

    /**
     * @param bool $increase
     */
    public function setIncrease($increase)
    {
        $this->increase = $increase;
    }

    /**
     * @return OrderModifierDetails
     */
    public function getModifierDetails()
    {
        return $this->modifierDetails;
    }

    /**
     * @param OrderModifierDetails $modifierDetails
     */
    public function setModifierDetails(OrderModifierDetails $modifierDetails)
    {
        $this->modifierDetails = $modifierDetails;
    }
}
