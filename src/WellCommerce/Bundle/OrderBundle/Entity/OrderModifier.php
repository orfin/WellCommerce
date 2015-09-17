<?php

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;

/**
 * Class OrderModifier
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderModifier implements OrderModifierInterface
{
    use HierarchyTrait;
    use OrderAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $netValue;

    /**
     * @var float
     */
    protected $taxValue;

    /**
     * @var float
     */
    protected $grossValue;

    /**
     * @var bool
     */
    protected $increase;

    /**
     * @var OrderModifierDetailsInterface
     */
    protected $modifierDetails;

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
    public function getNetValue()
    {
        return $this->netValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setNetValue($netValue)
    {
        $this->netValue = (float)$netValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxValue()
    {
        return $this->taxValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxValue($taxValue)
    {
        $this->taxValue = (float)$taxValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getGrossValue()
    {
        return $this->grossValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setGrossValue($grossValue)
    {
        $this->grossValue = (float)$grossValue;
    }

    /**
     * {@inheritdoc}
     */
    public function isIncrease()
    {
        return $this->increase;
    }

    /**
     * {@inheritdoc}
     */
    public function setIncrease($increase)
    {
        $this->increase = (bool)$increase;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierDetails()
    {
        return $this->modifierDetails;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifierDetails(OrderModifierDetailsInterface $modifierDetails)
    {
        $this->modifierDetails = $modifierDetails;
    }
}
