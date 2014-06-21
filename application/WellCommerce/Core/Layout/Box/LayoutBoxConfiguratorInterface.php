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

namespace WellCommerce\Core\Layout\Box;

use WellCommerce\Core\Component\Form\Elements\Fieldset;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Event\FormEvent;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{
    /**
     * Checks whether given layout page can handle such a layout box
     *
     * @param string $layoutPage
     *
     * @return mixed
     */
    public function isAvailableForLayoutPage($layoutPage);

    /**
     * Prepares layout box configuration fields
     *
     * @param FormEvent $event
     *
     * @return mixed
     */
    public function addConfigurationFields(FormEvent $event);

    /**
     * Adds box configuration options to settings fieldset
     *
     * @return mixed
     */
    public function addBoxConfiguration();
}