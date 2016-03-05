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

namespace WellCommerce\Bundle\ReviewBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ReviewManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('review.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ReviewBundle\Manager\Admin\ReviewManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ReviewBundle\Form\Admin\ReviewFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ReviewBundle\DataGrid\ReviewDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ReviewBundle\Repository\ReviewRepositoryInterface::class;
    }
}
