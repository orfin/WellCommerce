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

namespace WellCommerce\Bundle\ReviewBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Class ReviewInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ReviewInterface extends ProductAwareInterface, TimestampableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getNick();

    /**
     * @param string $nick
     */
    public function setNick($nick);

    /**
     * @return string
     */
    public function getReview();

    /**
     * @param string $review
     */
    public function setReview($review);

    /**
     * @return int
     */
    public function getRating();

    /**
     * @param int $rating
     */
    public function setRating($rating);
}
