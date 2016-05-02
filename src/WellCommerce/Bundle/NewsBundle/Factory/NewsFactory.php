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

namespace WellCommerce\Bundle\NewsBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\NewsBundle\Entity\NewsInterface;

/**
 * Class NewsFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = NewsInterface::class;
    
    /**
     * @return NewsInterface
     */
    public function create() : NewsInterface
    {
        /** @var $news NewsInterface */
        $news = $this->init();
        $news->setFeatured(false);
        $news->setPublish(true);
        $news->setStartDate(new \DateTime());
        $news->setEndDate(new \DateTime());
        
        return $news;
    }
}
