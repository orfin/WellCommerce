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

namespace WellCommerce\Bundle\AppBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ProductManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('product.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\Bundle\AppBundle\Manager\Admin\ProductManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\AppBundle\Form\Admin\ProductFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\AppBundle\DataGrid\ProductDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\AppBundle\Repository\ProductRepositoryInterface';
    }
}
