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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Entity\News;
use WellCommerce\CoreBundle\Factory\AbstractFactory;

class NewsFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\NewsInterface
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
