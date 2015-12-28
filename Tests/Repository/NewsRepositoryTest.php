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

namespace WellCommerce\Bundle\NewsBundle\Tests\Repository;

use WellCommerce\Bundle\CoreBundle\Test\Repository\AbstractRepositoryTestCase;

/**
 * Class NewsRepositoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsRepositoryTest extends AbstractRepositoryTestCase
{
    protected function getAlias()
    {
        return 'news';
    }

    protected function get()
    {
        return $this->container->get('news.repository');
    }
}
