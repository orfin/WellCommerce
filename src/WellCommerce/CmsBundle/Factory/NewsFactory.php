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

namespace WellCommerce\CmsBundle\Factory;

use WellCommerce\CmsBundle\Entity\News;
use WellCommerce\AppBundle\Factory\AbstractFactory;

class NewsFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\CmsBundle\Entity\NewsInterface
     */
    public function create()
    {
        $news = new News();
        $news->setFeatured(false);
        $news->setPublish(true);
        $news->setStartDate(new \DateTime());

        return $news;
    }
}
