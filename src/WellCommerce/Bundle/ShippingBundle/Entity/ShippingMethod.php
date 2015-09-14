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

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\IntlBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\TaxBundle\Entity\TaxAwareTrait;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;

/**
 * Class ShippingMethod
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethod implements ShippingMethodInterface
{
    use Translatable, Timestampable, Blameable, EnableableTrait, HierarchyAwareTrait, TaxAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $calculator;

    /**
     * @ORM\Column(name="currency", type="string", nullable=false, length=16)
     */
    protected $currency;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCost", mappedBy="shippingMethod", cascade={"persist"}, orphanRemoval=true)
     */
    protected $costs;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns shipping method processor
     *
     * @return string
     */
    public function getCalculator()
    {
        return $this->calculator;
    }

    /**
     * Sets shipping method calculator
     *
     * @param $calculator
     */
    public function setCalculator($calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * @return Collection
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * @param Collection $costs
     */
    public function setCosts(Collection $costs)
    {
        $this->costs = $costs;
    }

    /**
     * @return CurrencyInterface
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param CurrencyInterface $currency
     */
    public function setCurrency(CurrencyInterface $currency)
    {
        $this->currency = $currency;
    }
}
