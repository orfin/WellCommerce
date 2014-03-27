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
namespace WellCommerce\Plugin\Company\Event;

use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class CompanyDataGridEvent
 *
 * @package WellCommerce\Plugin\Company\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CompanyDataGridEvent extends DataGridEvent
{

    const DATAGRID_INIT_EVENT = 'company.datagrid.init';
}