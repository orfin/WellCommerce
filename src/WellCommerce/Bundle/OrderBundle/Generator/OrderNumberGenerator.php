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

namespace WellCommerce\Bundle\OrderBundle\Generator;

use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;

/**
 * Class OrderNumberGenerator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderNumberGenerator implements OrderNumberGeneratorInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * OrderNumberGenerator constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function generateOrderNumber(OrderInterface $order) : string
    {
        // TODO: Implement generateOrderNumber() method.
    }

    private function findLastOrderToday()
    {

    }
}
