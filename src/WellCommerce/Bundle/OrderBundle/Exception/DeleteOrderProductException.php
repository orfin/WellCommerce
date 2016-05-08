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

namespace WellCommerce\Bundle\OrderBundle\Exception;

use WellCommerce\Bundle\OrderBundle\Entity\OrderProductInterface;

/**
 * Class DeleteOrderProductException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DeleteOrderProductException extends \RuntimeException
{
    const ERROR_MESSAGE = 'Cannot delete item "%s". It does not belongs to order.';

    public function __construct(OrderProductInterface $orderProduct)
    {
        $message = sprintf(self::ERROR_MESSAGE, $orderProduct->getId());
        parent::__construct($message);
    }
}
