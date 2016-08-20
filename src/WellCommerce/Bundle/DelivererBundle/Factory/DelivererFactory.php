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

namespace WellCommerce\Bundle\DelivererBundle\Factory;

use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;
use WellCommerce\Bundle\DelivererBundle\Entity\DelivererInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;

/**
 * Class DelivererFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererFactory extends AbstractEntityFactory
{
    public function create() : DelivererInterface
    {
        $deliverer = new Deliverer();
        $deliverer->setProducers($this->createEmptyCollection());

        return $deliverer;
    }
}
