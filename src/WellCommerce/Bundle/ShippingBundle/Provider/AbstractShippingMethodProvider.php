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
use Doctrine\Common\Util\Debug;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingMethodCalculatorCollection;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;
use WellCommerce\Bundle\ShippingBundle\Exception\CalculatorNotFoundException;
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
    public function __construct(
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        ShippingMethodCalculatorCollection $shippingMethodCalculatorCollection
    ) {
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
     * Returns all enabled shipping methods which are supporting product calculations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    protected function getSupportedShippingMethods()
    {
        $methods = $this->getEnabledMethods();

        $supportedMethods = $methods->filter(function (ShippingMethodInterface $shippingMethod) {
            $paymentMethodsCount     = $shippingMethod->getPaymentMethods()->count();
            $shippingMethodCostCount = $shippingMethod->getCosts()->count();

            return $paymentMethodsCount > 0 && $shippingMethodCostCount > 0;
        });

        return $supportedMethods;
    }
}
