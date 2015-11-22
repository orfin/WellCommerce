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

namespace WellCommerce\CatalogBundle\Factory;

use WellCommerce\CatalogBundle\Entity\Unit;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class UnitFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CatalogBundle\Entity\UnitInterface
     */
    public function create()
    {
        $unit = new Unit();
        $unit->setCreatedAt(new \DateTime());

        return $unit;
    }
}
