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

use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

/**
 * Class AvailabilityFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = AvailabilityInterface::class;

    /**
     * @return AvailabilityInterface
     */
    public function create()
    {
        /** @var $availability AvailabilityInterface */
        $availability = $this->init();

        return $availability;
    }
}
