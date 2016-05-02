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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusHistoryInterface;

/**
 * Class OrderStatusHistoryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusHistoryFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = OrderStatusHistoryInterface::class;
    
    /**
     * @return OrderStatusHistoryInterface
     */
    public function create() : OrderStatusHistoryInterface
    {
        /** @var  $status OrderStatusHistoryInterface */
        $status = $this->init();
        $status->setComment('');
        $status->setNotify(false);
        
        return $status;
    }
}
