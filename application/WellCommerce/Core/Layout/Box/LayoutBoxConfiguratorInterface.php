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

use WellCommerce\Core\Form\Elements\Fieldset;

/**
 * Interface LayoutBoxConfiguratorInterface
 *
 * @package WellCommerce\Core\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxConfiguratorInterface
{

    /**
     * Returns layout box human-friendly name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Returns layout box alias
     *
     * @return mixed
     */
    public function getAlias();

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
     * @param Fieldset $fieldset
     *
     * @return mixed
     */
    public function addConfigurationFields(Fieldset $fieldset);

    /**
     * Every box should give the user instructions how to use it
     *
     * @return mixed
     */
    public function getHelp();

    /**
     * Return controller name which can handle such a configuration
     *
     * @return mixed
     */
    public function getController();
} 