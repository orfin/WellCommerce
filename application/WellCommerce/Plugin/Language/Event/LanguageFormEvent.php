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
namespace WellCommerce\Plugin\Language\Event;

use WellCommerce\Core\Event\FormEvent;

/**
 * Class LanguageFormEvent
 *
 * @package WellCommerce\Plugin\Language\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class LanguageFormEvent extends FormEvent
{

    const FORM_INIT_EVENT = 'language.form.init';
}