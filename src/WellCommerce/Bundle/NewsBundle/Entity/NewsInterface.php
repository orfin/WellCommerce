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

namespace WellCommerce\Bundle\NewsBundle\Entity;

use DateTime;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface NewsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface NewsInterface extends EntityInterface, TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return bool
     */
    public function getPublish() : bool;
    
    /**
     * @param bool $publish
     */
    public function setPublish(bool $publish);
    
    /**
     * @return DateTime
     */
    public function getStartDate() : DateTime;
    
    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate);
    
    /**
     * @return DateTime
     */
    public function getEndDate() : DateTime;
    
    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate);
    
    /**
     * @return bool
     */
    public function getFeatured() : bool;
    
    /**
     * @param bool $featured
     */
    public function setFeatured($featured);
}
