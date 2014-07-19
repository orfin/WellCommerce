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
namespace WellCommerce\PaymentMethod\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class PaymentMethodDataGridEvent
 *
 * @package WellCommerce\PaymentMethod\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentMethodDataGridEvent extends DataGridEvent
{

    const DATAGRID_INIT_EVENT = 'payment_method.datagrid.init';
}