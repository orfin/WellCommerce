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

namespace WellCommerce\Bundle\AppBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class MediaDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('media.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'media.id',
            'name'      => 'media.name',
            'mime'      => 'media.mime',
            'extension' => 'media.extension',
            'size'      => 'media.size',
            'preview'   => 'media.path',
        ];
    }
}
