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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyAwareTrait;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;
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
    use CurrencyAwareTrait;
    use ShopCollectionAwareTrait;
    
    protected $calculator      = '';
    protected $optionsProvider = '';
    protected $countries       = [];
    
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
    
    public function __construct()
    {
        $this->costs          = new ArrayCollection();
        $this->paymentMethods = new ArrayCollection();
        $this->shops          = new ArrayCollection();
    }
    
    public function getCalculator(): string
    {
        return $this->calculator;
    }
    
    public function setCalculator(string $calculator)
    {
        $this->calculator = $calculator;
    }
    
    public function getOptionsProvider(): string
    {
        return $this->optionsProvider;
    }
    
    public function setOptionsProvider(string $optionsProvider)
    {
        $this->optionsProvider = $optionsProvider;
    }
    
    public function getCosts(): Collection
    {
        return $this->costs;
    }
    
    public function setCosts(Collection $costs)
    {
        $this->costs = $costs;
    }
    
    public function getPaymentMethods(): Collection
    {
        return $this->paymentMethods;
    }
    
    public function getCountries(): array
    {
        return $this->countries;
    }
    
    public function setCountries(array $countries)
    {
        $this->countries = $countries;
    }
}
