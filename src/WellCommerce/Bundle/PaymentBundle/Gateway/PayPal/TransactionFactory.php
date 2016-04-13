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

namespace WellCommerce\Bundle\PaymentBundle\Gateway\PayPal;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;

/**
 * Class TransactionFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TransactionFactory
{
    public function createOrderTransaction(OrderInterface $order) : Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->createAmount($order));
        $transaction->setItemList($this->createItemList($order));
        $transaction->setDescription($order->getId());

        return $transaction;
    }
    
    /**
     * Creates an amount definition for given order
     *
     * @param OrderInterface $order
     *
     * @return Amount
     */
    protected function createAmount(OrderInterface $order) : Amount
    {
        $details = $this->createDetails($order);
        $amount  = new Amount();
        $amount->setCurrency($order->getCurrency());
        $amount->setTotal($order->getOrderTotal()->getGrossAmount());
        $amount->setDetails($details);
        
        return $amount;
    }
    
    /**
     * Creates PayPal payment details from given order
     *
     * @param OrderInterface $order
     *
     * @return Details
     */
    protected function createDetails(OrderInterface $order) : Details
    {
        $details = new Details();
        $details->setShipping($order->getShippingTotal()->getNetAmount());
        $details->setTax($order->getOrderTotal()->getTaxAmount());
        $details->setSubtotal($order->getProductTotal()->getNetAmount());
        
        return $details;
    }

    /**
     * Creates a collection of PayPal items for given order
     *
     * @param OrderInterface $order
     *
     * @return ItemList
     */
    protected function createItemList(OrderInterface $order) : ItemList
    {
        $itemList = new ItemList();

        $order->getProducts()->map(function (OrderProductInterface $orderProduct) use ($itemList) {
            $itemList->addItem($this->createItem($orderProduct));
        });

        return $itemList;
    }

    /**
     * Creates a single PayPal item from given order product
     *
     * @param OrderProductInterface $orderProduct
     *
     * @return Item
     */
    protected function createItem(OrderProductInterface $orderProduct) : Item
    {
        $item = new Item();
        $item->setName($orderProduct->getProduct()->translate()->getName());
        $item->setCurrency($orderProduct->getSellPrice()->getCurrency());
        $item->setQuantity($orderProduct->getQuantity());
        $item->setSku($orderProduct->getProduct()->getSku());
        $item->setPrice($orderProduct->getSellPrice()->getNetAmount());
        $item->setTax($orderProduct->getSellPrice()->getTaxAmount());

        return $item;
    }
}
