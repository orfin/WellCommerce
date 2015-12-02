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
 * Class AvailabilityAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait AvailabilityAwareTrait
{
    /**
     * @var null|AvailabilityInterface
     */
    protected $availability;

    /**
     * @return null|AvailabilityInterface
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param null|AvailabilityInterface $availability
     */
    public function setAvailability(AvailabilityInterface $availability = null)
    {
        $this->availability = $availability;
    }
}
