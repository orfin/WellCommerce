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
 * Interface AvailabilityAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface AvailabilityAwareInterface
{
    /**
     * @param AvailabilityInterface $availability
     */
    public function setAvailability(AvailabilityInterface $availability);

    /**
     * @return AvailabilityInterface
     */
    public function getAvailability();
}
