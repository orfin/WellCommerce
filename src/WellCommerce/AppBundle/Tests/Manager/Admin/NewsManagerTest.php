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

use WellCommerce\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class NewsManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('news.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\AppBundle\Manager\Admin\NewsManager::class;
    }
    
    protected function getFormBuilderClassName()
    {
        return \WellCommerce\AppBundle\Form\Admin\NewsFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\AppBundle\DataGrid\NewsDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\AppBundle\Repository\NewsRepositoryInterface::class;
    }
}
