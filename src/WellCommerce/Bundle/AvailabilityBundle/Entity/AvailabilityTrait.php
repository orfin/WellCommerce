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

namespace WellCommerce\Bundle\AvailabilityBundle\Entity;

/**
 * Class AvailabilityTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AvailabilityTrait
{
    /**
     * @var AvailabilityInterface
     */
    protected $availability;

    /**
     * @return AvailabilityInterface
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param AvailabilityInterface $availability
     */
    public function setAvailability(AvailabilityInterface $availability)
    {
        $this->availability = $availability;
    }
}
