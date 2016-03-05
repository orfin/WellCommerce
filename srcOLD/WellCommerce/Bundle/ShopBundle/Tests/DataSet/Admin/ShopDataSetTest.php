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

namespace WellCommerce\Bundle\ShopBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class ShopDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('shop.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'       => 'shop.id',
            'name'     => 'shop.name',
            'url'      => 'shop.url',
            'theme'    => 'shop_theme.name',
            'company'  => 'shop_company.name',
            'currency' => 'shop.defaultCurrency',
            'country'  => 'shop.defaultCountry',
        ];
    }
}
