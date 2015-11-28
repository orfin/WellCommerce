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

namespace WellCommerce\Bundle\AppBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;
use WellCommerce\Bundle\AppBundle\Entity\OrderTotalDetail;

/**
 * Class OrderTotalDetailFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalDetailFactory extends AbstractFactory implements FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\AppBundle\Entity\OrderTotalDetailInterface
     */
    public function create()
    {
        $detail = new OrderTotalDetail();
        $detail->setSubtraction(false);

        return $detail;
    }
}
