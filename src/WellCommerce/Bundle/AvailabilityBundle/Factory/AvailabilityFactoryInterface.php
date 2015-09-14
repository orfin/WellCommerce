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

namespace WellCommerce\Bundle\AvailabilityBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\FactoryInterface;

/**
 * Interface AvailabilityFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AvailabilityFactoryInterface extends FactoryInterface
{
    /**
     * @return \WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface
     */
    public function create();
}
