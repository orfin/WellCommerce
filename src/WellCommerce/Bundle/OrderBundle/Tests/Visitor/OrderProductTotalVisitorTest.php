<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\OrderBundle\Tests\Visitor;

use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProduct;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;
use WellCommerce\Bundle\TaxBundle\Helper\TaxHelper;

/**
 * Class OrderProductTotalVisitorTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderProductTotalVisitorTest extends AbstractTestCase
{
    public function testOrderSummary()
    {
        $delta      = 0.0001;
        $visitor    = $this->container->get('product_total.order.visitor');
        $iterations = 100;
        for ($i = 0; $i < $iterations; $i++) {
            $total              = rand(50, 100);
            $summaryGrossAmount = 0;
            $summaryNetAmount   = 0;
            $summaryTaxAmount   = 0;
            $summaryQuantity    = 0;
            $summaryWeight      = 0;
            
            $order = new Order();
            $order->setCurrency('EUR');
            
            for ($i = 0; $i < $total; $i++) {
                $orderProduct = $this->createOrderProduct();
                $order->addProduct($orderProduct);
                $sellPrice = $orderProduct->getSellPrice();
                $quantity  = $orderProduct->getQuantity();
                
                $this->assertEquals($sellPrice->getGrossAmount() - $sellPrice->getTaxAmount(), $sellPrice->getNetAmount());
                
                $quantityGrossAmount = round($sellPrice->getGrossAmount() * $quantity, 2);
                $quantityNetAmount   = round($sellPrice->getNetAmount() * $quantity, 2);
                $quantityTaxAmount   = round($sellPrice->getTaxAmount() * $quantity, 2);
                
                $this->assertEquals($quantityGrossAmount - $quantityTaxAmount, $quantityNetAmount, '', $delta);
                
                $summaryGrossAmount += $quantityGrossAmount;
                $summaryNetAmount += $quantityNetAmount;
                $summaryTaxAmount += $quantityTaxAmount;
                $summaryQuantity += $quantity;
                $summaryWeight += round($orderProduct->getWeight() * $quantity, 4);
            }
            
            $visitor->visitOrder($order);
            $this->assertEquals($order->getProductTotal()->getGrossPrice(), $summaryGrossAmount, '', $delta);
            $this->assertEquals($order->getProductTotal()->getNetPrice(), $summaryNetAmount, '', $delta);
            $this->assertEquals($order->getProductTotal()->getTaxAmount(), $summaryTaxAmount, '', $delta);
            $this->assertEquals($order->getProductTotal()->getWeight(), $summaryWeight, '', $delta);
            $this->assertEquals($order->getProductTotal()->getQuantity(), $summaryQuantity, '', $delta);
        }
    }
    
    private function createOrderProduct(): OrderProductInterface
    {
        $faker       = $this->getFakerGenerator();
        $grossAmount = $faker->randomFloat(2);
        $taxRate     = array_rand([0, 8, 23]);
        $netAmount   = TaxHelper::calculateNetPrice($grossAmount, $taxRate);
        $taxAmount   = $grossAmount - $netAmount;
        $sellPrice   = new DiscountablePrice();
        $sellPrice->setGrossAmount($grossAmount);
        $sellPrice->setNetAmount($netAmount);
        $sellPrice->setTaxAmount($taxAmount);
        $sellPrice->setCurrency('EUR');
        $sellPrice->setTaxRate($taxRate);
        
        $orderProduct = new OrderProduct();
        $orderProduct->setBuyPrice(new Price());
        $orderProduct->setSellPrice($sellPrice);
        $orderProduct->setQuantity(rand(1, 50));
        $orderProduct->setWeight($faker->randomFloat(2));
        
        return $orderProduct;
    }
    
}
