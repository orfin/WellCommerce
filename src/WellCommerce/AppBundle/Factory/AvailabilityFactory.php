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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Entity\Availability;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class AvailabilityFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\AvailabilityInterface
     */
    public function create()
    {
        $availability = new Availability();

        return $availability;
    }
}
