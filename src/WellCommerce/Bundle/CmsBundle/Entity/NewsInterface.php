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

namespace WellCommerce\Bundle\CmsBundle\Entity;

use DateTime;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;

/**
 * Interface NewsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface NewsInterface extends TimestampableInterface, TranslatableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return bool
     */
    public function getPublish();

    /**
     * @param bool $publish
     */
    public function setPublish($publish);

    /**
     * @return DateTime
     */
    public function getStartDate();

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate);

    /**
     * @return DateTime
     */
    public function getEndDate();

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate);

    /**
     * @return bool
     */
    public function getFeatured();

    /**
     * @param bool $featured
     */
    public function setFeatured($featured);
}
