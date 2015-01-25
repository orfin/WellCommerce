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

namespace WellCommerce\Bundle\CoreBundle\Form\Event;

use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;

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