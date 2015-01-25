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

namespace WellCommerce\Bundle\DataGridBundle\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\DataGridBundle\Configuration\Appearance;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandlers;
use WellCommerce\Bundle\DataGridBundle\Configuration\Filters;
use WellCommerce\Bundle\DataGridBundle\Configuration\Mechanics;
use WellCommerce\Bundle\DataGridBundle\Configuration\RowActions;

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
     *
     * @return void
     */
    public function setIdentifier($identifier);

    /**
     * Returns current DataGrid identifier
     *
     * @return string
     */
    public function getIdentifier();

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
    public function getAppearance();

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
    public function getMechanics();

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
    public function getEventHandlers();
}
