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

namespace WellCommerce\Bundle\LocaleBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class LocaleDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('locale.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'       => 'locale.id',
            'code'     => 'locale.code',
            'currency' => 'default_currency.code',
        ];
    }
}
