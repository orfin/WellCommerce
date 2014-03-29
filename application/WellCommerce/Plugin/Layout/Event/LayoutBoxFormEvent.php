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
namespace WellCommerce\Plugin\Layout\Event;

use WellCommerce\Core\Event\FormEvent;

/**
 * Class LayoutBoxFormEvent
 *
 * @package WellCommerce\Plugin\Layout\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LayoutBoxFormEvent extends FormEvent
{

    const FORM_INIT_EVENT            = 'layout_box.form.init';
    const FORM_GET_BOX_TYPES         = 'layout_box.form.get_types';
}