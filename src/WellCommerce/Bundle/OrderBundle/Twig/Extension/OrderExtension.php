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
namespace WellCommerce\Bundle\OrderBundle\Twig\Extension;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Provider\Front\OrderProviderInterface;
use WellCommerce\Bundle\ShippingBundle\Context\OrderContext;
use WellCommerce\Bundle\ShippingBundle\Provider\ShippingMethodProviderInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class OrderExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderExtension extends \Twig_Extension
{
    /**
     * @var OrderProviderInterface
     */
    private $orderProvider;
    
    /**
     * @var DataSetInterface
     */
    private $orderProductDataSet;
    
    /**
     * @var ShippingMethodProviderInterface
     */
    private $shippingMethodProvider;
    
    /**
     * OrderExtension constructor.
     *
     * @param OrderProviderInterface          $orderProvider
     * @param DataSetInterface                $dataset
     * @param ShippingMethodProviderInterface $shippingMethodProvider
     */
    public function __construct(
        OrderProviderInterface $orderProvider,
        DataSetInterface $dataset,
        ShippingMethodProviderInterface $shippingMethodProvider
    ) {
        $this->orderProvider          = $orderProvider;
        $this->orderProductDataSet    = $dataset;
        $this->shippingMethodProvider = $shippingMethodProvider;
    }
    
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getCurrentOrder', [$this, 'getCurrentOrder'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('hasCurrentOrder', [$this, 'hasCurrentOrder'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('currentOrderProducts', [$this, 'getCurrentOrderProducts'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('getShippingCostForCurrentOrder', [$this, 'getShippingCostForCurrentOrder'], ['is_safe' => ['html']]),
        ];
    }
    
    public function hasCurrentOrder() : bool
    {
        return $this->orderProvider->hasCurrentOrder();
    }
    
    public function getCurrentOrder() : OrderInterface
    {
        return $this->orderProvider->getCurrentOrder();
    }
    
    public function getCurrentOrderProducts() : array
    {
        return $this->orderProductDataSet->getResult('array', [], ['pagination' => false]);
    }
    
    public function getShippingCostForCurrentOrder()
    {
        if ($this->hasCurrentOrder()) {
            $shippingCosts = $this->shippingMethodProvider->getCosts(new OrderContext($this->getCurrentOrder()));
            
            if ($shippingCosts->count()) {
                return $shippingCosts->first();
            }
        }
        
        return null;
    }
    
    public function getName()
    {
        return 'order';
    }
}
