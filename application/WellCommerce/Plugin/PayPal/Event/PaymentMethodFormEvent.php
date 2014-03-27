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
namespace WellCommerce\Plugin\PaymentMethod\Event;

use WellCommerce\Core\Event\FormEvent;

/**
 * Class PaymentMethodFormEvent
 *
 * @package WellCommerce\Plugin\PaymentMethod\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PaymentMethodFormEvent extends FormEvent
{

    const FORM_INIT_EVENT = 'paypal.form.init';
}