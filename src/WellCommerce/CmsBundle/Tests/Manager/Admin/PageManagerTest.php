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

namespace WellCommerce\CmsBundle\Tests\Manager\Admin;

use WellCommerce\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

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
        return \WellCommerce\CmsBundle\Manager\Admin\PageManager::class;
    }
    
    protected function getFormBuilderClassName()
    {
        return \WellCommerce\CmsBundle\Form\Admin\PageFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\CmsBundle\DataGrid\PageDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\CmsBundle\Repository\PageRepositoryInterface::class;
    }
}
