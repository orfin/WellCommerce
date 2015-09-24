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

namespace WellCommerce\Bundle\CmsBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
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
        return 'WellCommerce\Bundle\CmsBundle\Manager\Admin\ContactManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\CmsBundle\Form\Admin\ContactFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\CmsBundle\DataGrid\ContactDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\CmsBundle\Repository\ContactRepositoryInterface';
    }
}
