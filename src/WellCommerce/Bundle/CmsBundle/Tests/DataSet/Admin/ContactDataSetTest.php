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
 * Class ContactDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('contact.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'   => 'contact.id',
            'name' => 'contact_translation.name',
        ];
    }
}
