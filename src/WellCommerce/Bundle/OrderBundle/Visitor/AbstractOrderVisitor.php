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

namespace WellCommerce\Bundle\OrderBundle\Visitor;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotalDetailInterface;
use WellCommerce\Bundle\OrderBundle\Factory\OrderTotalDetailFactory;

/**
 * Class AbstractOrderVisitor
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOrderVisitor extends AbstractContainerAware implements OrderVisitorInterface
{
    protected function getOrderTotalDetailFactory() : OrderTotalDetailFactory
    {
        return $this->get('order_total_detail.factory');
    }
}
