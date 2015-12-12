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

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotalDetailInterface;

/**
 * Class OrderTotalDetailFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalDetailFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = OrderTotalDetailInterface::class;

    /**
     * @return OrderTotalDetailInterface
     */
    public function create()
    {
        /** @var  $detail OrderTotalDetailInterface */
        $detail = $this->init();
        $detail->setSubtraction(false);

        return $detail;
    }
}
