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

namespace WellCommerce\Core\DataGrid\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Core\DataGrid\Configuration\Appearance;
use WellCommerce\Core\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\DataGrid\Configuration\Mechanics;
use WellCommerce\Core\DataGrid\Configuration\RowActions;

/**
 * Class OptionsInterface
 *
 * @package WellCommerce\Core\DataGrid\Options
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionsInterface
{
    /**
     * Configures all options using OptionsResolver
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolverInterface $resolver);

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

    /**
     * Sets row actions for DataGrid
     *
     * @param RowActions $rowActions
     *
     * @return void
     */
    public function setRowActions(RowActions $rowActions);

    /**
     * Returns row actions for DataGrid
     *
     * @return RowActions
     */
    public function getRowActions();
} 