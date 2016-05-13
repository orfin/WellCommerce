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
     * OrderExtension constructor.
     *
     * @param OrderProviderInterface $orderStorage
     * @param DataSetInterface       $dataset
     */
    public function __construct(OrderProviderInterface $orderProvider, DataSetInterface $dataset)
    {
        $this->orderProvider       = $orderProvider;
        $this->orderProductDataSet = $dataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getCurrentOrder', [$this, 'getCurrentOrder'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('hasCurrentOrder', [$this, 'hasCurrentOrder'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('currentOrderProducts', [$this, 'getCurrentOrderProducts'], ['is_safe' => ['html']]),
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

    public function getName()
    {
        return 'order';
    }
}
