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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderSummary;
use WellCommerce\Bundle\OrderBundle\Entity\OrderSummaryInterface;

/**
 * Class OrderSummaryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderSummaryFactory extends AbstractEntityFactory
{
    public function create() : OrderSummaryInterface
    {
        $summary = new OrderSummary();
        $summary->setGrossAmount(0);
        $summary->setNetAmount(0);
        $summary->setTaxAmount(0);
        
        return $summary;
    }
}
