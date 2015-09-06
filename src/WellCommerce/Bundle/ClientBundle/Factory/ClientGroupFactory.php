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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class ClientGroupFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupFactory extends AbstractFactory
{
    /**
     * @return ClientGroup
     */
    public function create()
    {
        $clientGroup = new ClientGroup();
        $clientGroup->setDiscount(0);

        return $clientGroup;
    }
}
