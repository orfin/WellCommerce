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

namespace WellCommerce\Bundle\CmsBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class NewsDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('news.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'   => 'news.id',
            'name' => 'news_translation.topic',
        ];
    }
}
