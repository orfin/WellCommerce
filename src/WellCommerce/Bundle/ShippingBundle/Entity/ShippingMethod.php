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
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\TaxBundle\Entity\TaxAwareTrait;

/**
 * Class ShippingMethod
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethod implements ShippingMethodInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    use EnableableTrait;
    use HierarchyAwareTrait;
    use TaxAwareTrait;
    
    /**
     * @var string
     */
    protected $calculator;
    
    /**
     * @var string
     */
    protected $optionsProvider;
    
    /**
     * @var CurrencyInterface
     */
    protected $currency;
    
    /**
     * @var Collection
     */
    protected $costs;
    
    /**
     * @var Collection
     */
    protected $paymentMethods;
    
    /**
     * @var array
     */
    protected $countries;
    
    /**
     * {@inheritdoc}
     */
    public function getCalculator() : string
    {
        return $this->calculator;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCalculator(string $calculator)
    {
        $this->calculator = $calculator;
    }
    
    /**
     * @return string
     */
    public function getOptionsProvider() : string
    {
        return $this->optionsProvider;
    }
    
    /**
     * @param string $optionsProvider
     */
    public function setOptionsProvider(string $optionsProvider)
    {
        $this->optionsProvider = $optionsProvider;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCosts() : Collection
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
    public function setCurrency(CurrencyInterface $currency = null)
    {
        $this->currency = $currency;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPaymentMethods() : Collection
    {
        return $this->paymentMethods;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCountries(): array
    {
        return $this->countries;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCountries(array $countries)
    {
        $this->countries = $countries;
    }
}
