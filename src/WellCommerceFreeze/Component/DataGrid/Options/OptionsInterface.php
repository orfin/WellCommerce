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

namespace WellCommerce\Component\DataGrid\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataGrid\Configuration\Appearance;
use WellCommerce\Component\DataGrid\Configuration\EventHandlers;
use WellCommerce\Component\DataGrid\Configuration\Mechanics;

/**
 * Class OptionsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionsInterface
{
    /**
     * Configures all options using OptionsResolver
     *
     * @param OptionsResolver $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Sets DataGrid identifier
     *
     * @param string $identifier
     */
    public function setIdentifier(string $identifier);

    /**
     * Returns current DataGrid identifier
     *
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * Sets appearance options for DataGrid
     *
     * @param Appearance $appearance
     *
     * @return void
     */
    public function setAppearance(Appearance $appearance);

    /**
     * Returns appearance options for DataGrid
     *
     * @return Appearance
     */
    public function getAppearance() : Appearance;

    /**
     * Sets mechanics options for DataGrid
     *
     * @param Mechanics $mechanics
     *
     * @return void
     */
    public function setMechanics(Mechanics $mechanics);

    /**
     * Returns mechanics options for DataGrid
     *
     * @return Mechanics
     */
    public function getMechanics() : Mechanics;

    /**
     * Sets event handlers for DataGrid
     *
     * @param EventHandlers $eventHandlers
     *
     * @return void
     */
    public function setEventHandlers(EventHandlers $eventHandlers);

    /**
     * Returns event handlers registered for DataGrid
     *
     * @return EventHandlers
     */
    public function getEventHandlers() : EventHandlers;
}
