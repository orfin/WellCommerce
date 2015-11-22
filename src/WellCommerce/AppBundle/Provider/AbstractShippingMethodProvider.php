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

namespace WellCommerce\AppBundle\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\AppBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\AppBundle\Calculator\ShippingMethodCalculatorCollection;
use WellCommerce\AppBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\AppBundle\Entity\ShippingMethodInterface;
use WellCommerce\AppBundle\Exception\CalculatorNotFoundException;
use WellCommerce\AppBundle\Repository\ShippingMethodRepositoryInterface;

/**
 * Class AbstractShippingMethodProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractShippingMethodProvider
{
    /**
     * @var ArrayCollection
     */
    protected $collection;

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
     * @return \WellCommerce\AppBundle\Calculator\ShippingMethodCalculatorInterface
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

    /**
     * Returns sorted costs collection
     *
     * @return ArrayCollection
     */
    protected function sortCollection()
    {
        $iterator = $this->collection->getIterator();
        $iterator->uasort(function (ShippingMethodCostInterface $a, ShippingMethodCostInterface $b) {
            return ($a->getCost()->getGrossAmount() < $b->getCost()->getGrossAmount()) ? -1 : 1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

    /**
     * Returns the collection of all shipping method costs for cart
     *
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return ArrayCollection
     */
    protected function getCollection(ShippingCalculatorSubjectInterface $subject)
    {
        $shippingMethodCostCollection = new ArrayCollection();
        $shippingMethods              = $this->getSupportedShippingMethods();

        $shippingMethods->map(function (ShippingMethodInterface $shippingMethod) use ($subject, $shippingMethodCostCollection) {
            $calculator = $this->getCalculator($shippingMethod);
            $costs      = $calculator->calculate($shippingMethod, $subject);
            if ($costs instanceof ShippingMethodCostInterface) {
                $shippingMethodCostCollection->add($costs);
            }
        });

        return $shippingMethodCostCollection;
    }
}
