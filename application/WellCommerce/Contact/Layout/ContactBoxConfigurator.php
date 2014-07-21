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

namespace WellCommerce\Contact\Layout;

use WellCommerce\Core\Form\Conditions\Equals;
use WellCommerce\Core\Form\Dependency;
use WellCommerce\Core\Form\Option;
use WellCommerce\Core\Event\FormEvent;
use WellCommerce\Core\Layout\Box\LayoutBoxConfigurator;
use WellCommerce\Core\Layout\Box\LayoutBoxConfiguratorInterface;

/**
 * Class ContactBoxConfigurator
 *
 * @package WellCommerce\Contact\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactBoxConfigurator extends LayoutBoxConfigurator implements LayoutBoxConfiguratorInterface
{
    /**
     * @var string ContactBoxConfigurator type
     */
    public $type;

    /**
     * @var string ContactBoxController service name
     */
    public $controller;

    /**
     * @var string ContactBoxConfigurator box name
     */
    public $name = 'ContactBox';

    /**
     * {@inheritdoc}
     */
    public function addBoxConfiguration()
    {
        $this->fieldset->addChild($this->builder->addCheckbox([
            'name'  => 'contact_form_enabled',
            'label' => 'Enable contact form',
            'comment' => $this->trans('Check if contact box should allow customers to send e-mails through contact form.')
        ]));

    }
} 