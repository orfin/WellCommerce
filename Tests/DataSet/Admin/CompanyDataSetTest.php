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

namespace WellCommerce\Bundle\CompanyBundle\Tests\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\Test\DataSet\AbstractDataSetTestCase;

/**
 * Class CompanyDataSetTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataSetTest extends AbstractDataSetTestCase
{
    protected function get()
    {
        return $this->container->get('company.dataset.admin');
    }

    protected function getColumns()
    {
        return [
            'id'        => 'company.id',
            'name'      => 'company.name',
            'shortName' => 'company.shortName',
            'createdAt' => 'company.createdAt',
        ];
    }
}
