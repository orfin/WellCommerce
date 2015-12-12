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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\OrderBundle\Entity\Order;

/**
 * Class OrderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\Bundle\OrderBundle\Entity\OrderInterface
     */
    public function create()
    {
        $order = new Order();
        $order->setProducts(new ArrayCollection());
        $order->setPayments(new ArrayCollection());
        $order->setTotals(new ArrayCollection());

        return $order;
    }


}
