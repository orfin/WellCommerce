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
namespace WellCommerce\Plugin\Availability\Controller\Admin;

use WellCommerce\Core\Component\Controller\AbstractAdminController;

/**
 * Class AvailabilityController
 *
 * @package WellCommerce\Plugin\Availability\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('availability.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->get('availability.repository');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->get('availability.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.availability.index';
    }
}
