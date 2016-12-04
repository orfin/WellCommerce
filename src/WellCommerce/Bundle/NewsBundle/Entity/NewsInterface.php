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
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface NewsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface NewsInterface extends EntityInterface, TimestampableInterface, TranslatableInterface, BlameableInterface
{
    public function getPublish(): bool;
    
    public function setPublish(bool $publish);
    
    public function getStartDate(): DateTime;
    
    public function setStartDate(DateTime $startDate);
    
    public function getEndDate(): DateTime;
    
    public function setEndDate(DateTime $endDate);
    
    public function getFeatured(): bool;
    
    public function setFeatured($featured);
}
