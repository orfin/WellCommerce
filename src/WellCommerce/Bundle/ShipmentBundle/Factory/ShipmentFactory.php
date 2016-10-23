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

namespace WellCommerce\Bundle\ShipmentBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\ShipmentBundle\Entity\Shipment;
use WellCommerce\Bundle\ShipmentBundle\Entity\ShipmentInterface;

/**
 * Class ShipmentFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentFactory extends AbstractEntityFactory
{
    public function create() : ShipmentInterface
    {
        $shipment = new Shipment();
        $shipment->setCourier('');
        $shipment->setGuid($this->generateGuid());
        $shipment->setPackageNumber('');
        $shipment->setFormData([]);
        $shipment->setSent(false);
        
        return $shipment;
    }
    
    private function generateGuid() : string
    {
        mt_srand((double)microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $guid   = substr($charid, 0, 32);
        
        return $guid;
    }
}
