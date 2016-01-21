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

namespace WellCommerce\Bundle\ContactBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ContactManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('contact.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ContactBundle\Manager\Admin\ContactManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ContactBundle\Form\Admin\ContactFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ContactBundle\DataGrid\ContactDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ContactBundle\Repository\ContactRepositoryInterface::class;
    }
}
