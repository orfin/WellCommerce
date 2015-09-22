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
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCostReference;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorCollection;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Exception\CalculatorNotFoundException;
use WellCommerce\Bundle\ShippingBundle\Options\ShippingOption;
use WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepositoryInterface;

/**
 * Class AbstractShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShippingMethodProvider
{
    /**
     * @var ShippingMethodRepositoryInterface
     */
    protected $shippingMethodRepository;

    /**
     * @var ShippingMethodCalculatorCollection
     */
    protected $shippingMethodCalculatorCollection;

    /**
     * Constructor
     *
     * @param ShippingMethodRepositoryInterface  $shippingMethodRepository
     * @param ShippingMethodCalculatorCollection $shippingMethodCalculatorCollection
     */
    public function __construct(ShippingMethodRepositoryInterface $shippingMethodRepository, ShippingMethodCalculatorCollection $shippingMethodCalculatorCollection)
    {
        $this->shippingMethodRepository           = $shippingMethodRepository;
        $this->shippingMethodCalculatorCollection = $shippingMethodCalculatorCollection;
    }

    /**
     * Returns all enabled shipping methods as a collection
     *
     * @return ArrayCollection
     */
    protected function getEnabledMethods()
    {
        $methods = $this->shippingMethodRepository->findAllEnabledShippingMethods();

        return new ArrayCollection($methods);
    }

    /**
     * Returns the method's calculator instance
     *
     * @param ShippingMethodInterface $shippingMethod
     *
     * @return \WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorInterface
     */
    protected function getCalculator(ShippingMethodInterface $shippingMethod)
    {
        $calculator = $shippingMethod->getCalculator();

        if (!$this->shippingMethodCalculatorCollection->has($calculator)) {
            throw new CalculatorNotFoundException($calculator);
        }

        return $this->shippingMethodCalculatorCollection->get($calculator);
    }

    /**
     * Creates a new shipping option
     *
     * @param ShippingMethodInterface $shippingMethod
     * @param ShippingCostReference   $cost
     *
     * @return ShippingOption
     */
    protected function createShippingOption(ShippingMethodInterface $shippingMethod, ShippingCostReference $cost)
    {
        $options = [
            'id'          => $shippingMethod->getId(),
            'name'        => $shippingMethod->translate()->getName(),
            'tax_amount'  => $cost->getTaxAmount(),
            'net_price'   => $cost->getNetPrice(),
            'gross_price' => $cost->getGrossPrice(),
        ];

        return new ShippingOption($options);
    }
}
