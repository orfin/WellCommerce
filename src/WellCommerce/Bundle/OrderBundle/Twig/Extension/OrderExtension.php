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

use WellCommerce\Bundle\OrderBundle\Storage\OrderStorageInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class OrderExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderExtension extends \Twig_Extension
{
    /**
     * @var OrderStorageInterface
     */
    private $orderStorage;

    /**
     * @var DataSetInterface
     */
    private $orderProductDataSet;

    /**
     * OrderExtension constructor.
     *
     * @param OrderStorageInterface $orderStorage
     * @param DataSetInterface      $dataset
     */
    public function __construct(OrderStorageInterface $orderStorage, DataSetInterface $dataset)
    {
        $this->orderStorage        = $orderStorage;
        $this->orderProductDataSet = $dataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('currentOrder', [$this, 'getCurrentOrder'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('currentOrderProducts', [$this, 'getCurrentOrderProducts'], ['is_safe' => ['html']]),
        ];
    }

    public function getCurrentOrder()
    {
        return $this->orderStorage->getCurrentOrder();
    }

    public function getCurrentOrderProducts()
    {
        return $this->orderProductDataSet->getResult('array', [], ['pagination' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'order';
    }
}
