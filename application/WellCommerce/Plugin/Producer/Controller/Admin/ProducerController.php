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
namespace WellCommerce\Plugin\Producer\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;

/**
 * Class ProducerController
 *
 * @package WellCommerce\Plugin\Producer\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('producer.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('producer.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('producer.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.producer.index';
    }
}
