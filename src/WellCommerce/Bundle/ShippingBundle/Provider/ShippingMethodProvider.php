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

namespace WellCommerce\Bundle\ShippingBundle\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingSubjectInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Exception\CalculatorNotFoundException;
use WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepositoryInterface;

/**
 * Class ShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ShippingMethodProvider implements ShippingMethodProviderInterface
{
    /**
     * @var ShippingMethodRepositoryInterface
     */
    private $repository;
    
    /**
     * @var Collection
     */
    private $calculators;
    
    /**
     * AbstractShippingMethodProvider constructor.
     *
     * @param ShippingMethodRepositoryInterface $repository
     * @param Collection                        $calculators
     */
    public function __construct(ShippingMethodRepositoryInterface $repository, Collection $calculators)
    {
        $this->repository  = $repository;
        $this->calculators = $calculators;
    }
    
    public function getCosts(ShippingSubjectInterface $subject) : Collection
    {
        $methods    = $this->repository->getShippingMethods();
        $collection = new ArrayCollection();
        
        $methods->map(function (ShippingMethodInterface $shippingMethod) use ($subject, $collection) {
            $costs = $this->getShippingMethodCosts($shippingMethod, $subject);

            $costs->map(function (ShippingMethodCostInterface $cost) use ($collection) {
                $collection->add($cost);
            });
        });
        
        return $collection;
    }

    public function getShippingMethodCosts(ShippingMethodInterface $method, ShippingSubjectInterface $subject) : Collection
    {
        $calculator = $this->getCalculator($method);

        return $calculator->calculate($method, $subject);
    }
    
    private function getCalculator(ShippingMethodInterface $shippingMethod) : ShippingCalculatorInterface
    {
        $calculator = $shippingMethod->getCalculator();
        
        if (false === $this->calculators->containsKey($calculator)) {
            throw new CalculatorNotFoundException($calculator);
        }
        
        return $this->calculators->get($calculator);
    }
}
