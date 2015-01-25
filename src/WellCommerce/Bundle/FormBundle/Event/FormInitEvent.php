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

namespace WellCommerce\Bundle\FormBundle\Event;

use WellCommerce\Bundle\FormBundle\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Elements\FormInterface;

/**
 * Class FormInitEvent
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormInitEvent
{
    const EVENT_NAME = 'form.init';

    public function __construct(FormBuilderInterface $builder, FormInterface $form){

    }
} 