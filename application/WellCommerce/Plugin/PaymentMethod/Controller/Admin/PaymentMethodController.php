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
namespace WellCommerce\Plugin\PaymentMethod\Controller\Admin;

use WellCommerce\Core\Controller\AbstractAdminController;

/**
 * Class PaymentMethodController
 *
 * @package WellCommerce\Plugin\PaymentMethod\Controller\Admin
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getDataGrid()
    {
        return $this->get('payment_method.datagrid');
    }

    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('payment_method.repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getForm()
    {
        return $this->get('payment_method.form');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultRoute()
    {
        return 'admin.payment_method.index';
    }
}
