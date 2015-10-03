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

namespace WellCommerce\Bundle\OrderBundle\Collector;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;

/**
 * Class OrderClientDiscountCollector
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderClientDiscountCollector extends AbstractDataCollector
{
    /**
     * {@inheritdoc}
     */
    public function visitOrder(OrderInterface $order)
    {
        $discountTotal        = new OrderTotal();
        $productTotal         = $order->getProductTotal();
        $clientDiscountDetail = $this->initResource();
        $discount             = $this->getDiscountForClient($order->getClient());

        if ($discount > 0) {
            $discountTotal->setCurrency($order->getCurrency());
            $discountTotal->setGrossAmount($productTotal->getGrossAmount() * $discount);
            $discountTotal->setNetAmount($productTotal->getNetAmount() * $discount);
            $discountTotal->setTaxAmount($productTotal->getTaxAmount() * $discount);

            $clientDiscountDetail->setOrderTotal($discountTotal);
            $clientDiscountDetail->setModifierType('%');
            $clientDiscountDetail->setModifierValue($discount);
            $clientDiscountDetail->setOrder($order);
            $clientDiscountDetail->setSubtraction(true);

            $order->addTotal($clientDiscountDetail);
        }
    }

    /**
     * Returns client's discount
     *
     * @param null|ClientInterface $client
     *
     * @return float|int
     */
    protected function getDiscountForClient(ClientInterface $client = null)
    {
        if (null !== $client && null !== $client->getClientGroup()) {
            return round((float)$client->getClientGroup()->getDiscount() / 100, 2);
        }

        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'client_discount';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'order.label.client_discount_description';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 300;
    }
}
