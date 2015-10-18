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

namespace WellCommerce\Bundle\CmsBundle\Context\Front;

use WellCommerce\Bundle\CmsBundle\Entity\NewsInterface;

/**
 * Class NewsContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsContext implements NewsContextInterface
{
    /**
     * @var NewsInterface
     */
    protected $currentNews;

    /**
     * {@inheritdoc}
     */
    public function setCurrentNews(NewsInterface $news)
    {
        $this->currentNews = $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentNews()
    {
        return $this->currentNews;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentNews()
    {
        return $this->currentNews instanceof NewsInterface;
    }
}
