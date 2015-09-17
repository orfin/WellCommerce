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
     * @var CurrencyInterface
     */
    protected $currency;

    /**
     * @var Collection
     */
    protected $costs;

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
    public function getCalculator()
    {
        return $this->calculator;
    }

    /**
     * {@inheritdoc}
     */
    public function setCalculator($calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * {@inheritdoc}
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * {@inheritdoc}
     */
    public function setCosts(Collection $costs)
    {
        $this->costs = $costs;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrency(CurrencyInterface $currency)
    {
        $this->currency = $currency;
    }
}
