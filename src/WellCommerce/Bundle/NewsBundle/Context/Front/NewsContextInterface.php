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

namespace WellCommerce\Bundle\NewsBundle\Context\Front;

use WellCommerce\Bundle\NewsBundle\Entity\NewsInterface;

/**
 * Interface NewsContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface NewsContextInterface
{
    /**
     * @param NewsInterface $news
     */
    public function setCurrentNews(NewsInterface $news);

    /**
     * @return NewsInterface
     */
    public function getCurrentNews() : NewsInterface;

    /**
     * @return bool
     */
    public function hasCurrentNews() : bool;
}
