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

namespace WellCommerce\AppBundle\Tests\Manager\Admin;

use WellCommerce\AppBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class PageManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('page.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\AppBundle\Manager\Admin\PageManager::class;
    }
    
    protected function getFormBuilderClassName()
    {
        return \WellCommerce\AppBundle\Form\Admin\PageFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\AppBundle\DataGrid\PageDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\AppBundle\Repository\PageRepositoryInterface::class;
    }
}
