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

namespace WellCommerce\Bundle\CoreBundle\Entity;

use DateTime;

/**
 * Interface TimestampableInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TimestampableInterface
{
    /**
     * @return DateTime
     */
    public function getCreatedAt();
    
    /**
     * @return DateTime
     */
    public function getUpdatedAt();
    
    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt);
    
    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt);
    
    public function updateTimestamps();
}
