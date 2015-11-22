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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Helper\CurrencyHelperInterface;
use WellCommerce\AppBundle\Entity\Price;
use WellCommerce\AppBundle\Factory\AbstractFactory;
use WellCommerce\AppBundle\Entity\CartProductInterface;
use WellCommerce\AppBundle\Entity\OrderInterface;
use WellCommerce\AppBundle\Entity\OrderProduct;

/**
 * Class OrderProductFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductFactory extends AbstractFactory implements OrderProductFactoryInterface
{
    /**
     * @var CurrencyHelperInterface
     */
    protected $currencyHelper;

    /**
     * OrderProductFactory constructor.
     *
     * @param CurrencyHelperInterface $currencyHelper
     */
    public function __construct(CurrencyHelperInterface $currencyHelper)
    {
        $this->currencyHelper = $currencyHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $orderProduct = new OrderProduct();
        $orderProduct->setQuantity(0);
        $orderProduct->setWeight(0);

        return $orderProduct;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromCartProduct(CartProductInterface $cartProduct, OrderInterface $order)
    {
        $orderProduct   = new OrderProduct();
        $product        = $cartProduct->getProduct();
        $attribute      = $cartProduct->getAttribute();
        $sellPrice      = $cartProduct->getSellPrice();
        $baseCurrency   = $sellPrice->getCurrency();
        $targetCurrency = $order->getCurrency();

        $grossAmount = $this->currencyHelper->convert($sellPrice->getFinalGrossAmount(), $baseCurrency, $targetCurrency);
        $netAmount   = $this->currencyHelper->convert($sellPrice->getFinalNetAmount(), $baseCurrency, $targetCurrency);
        $taxAmount   = $this->currencyHelper->convert($sellPrice->getFinalTaxAmount(), $baseCurrency, $targetCurrency);

        $sellPrice = new Price();
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setTaxRate($sellPrice->getTaxRate());
        $sellPrice->setCurrency($targetCurrency);

        $orderProduct->setSellPrice($sellPrice);
        $orderProduct->setBuyPrice($product->getBuyPrice());
        $orderProduct->setQuantity($cartProduct->getQuantity());
        $orderProduct->setWeight($cartProduct->getWeight());
        $orderProduct->setProductAttribute($attribute);
        $orderProduct->setProduct($product);

        return $orderProduct;
    }
}
