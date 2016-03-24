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

namespace WellCommerce\Bundle\DictionaryBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class DictionaryManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DictionaryManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('dictionary.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\DictionaryBundle\Manager\Admin\DictionaryManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\DictionaryBundle\Form\Admin\DictionaryFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\DictionaryBundle\DataGrid\DictionaryDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\DictionaryBundle\Repository\DictionaryRepositoryInterface::class;
    }
}
