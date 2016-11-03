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

namespace WellCommerce\Bundle\NewsBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class NewsDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataSetTest extends AbstractDataSetTestCase
{
    protected function get ()
    {
        return $this->container->get('news.dataset.admin');
    }
    
    protected function getColumns ()
    {
        return [
            'id'        => 'news.id',
            'createdAt' => 'news.createdAt',
            'startDate' => 'news.startDate',
            'endDate'   => 'news.endDate',
            'topic'     => 'news_translation.topic',
            'summary'   => 'news_translation.summary',
            'content'   => 'news_translation.content',
            'slug'      => 'news_translation.slug',
            'locale'    => 'news_translation.locale',
            'route'     => 'IDENTITY(news_translation.route)',
            'publish'   => 'news.publish',
            'featured'  => 'news.featured',
            'photo'     => 'photos.path',
        ];
    }
}
