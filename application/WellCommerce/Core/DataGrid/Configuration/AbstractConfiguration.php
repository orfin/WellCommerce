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

namespace WellCommerce\Core\DataGrid\Configuration;

/**
 * Class AbstractConfiguration
 *
 * @package WellCommerce\Core\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractConfiguration
{
    /**
     * @var string Identifier
     */
    protected $id;

    /**
     * @var object Appearance options
     */
    protected $appearance;

    /**
     * @var object Mechanics settings
     */
    protected $mechanics;

    /**
     * @var object Registered event handlers
     */
    protected $eventHandlers;

    /**
     * @var object Preprocessed filters
     */
    protected $filters;

    /**
     * @var object Possible row actions
     */
    protected $rowActions;

    /**
     * {@inheritdoc}
     */
    public function setId($identifier)
    {
        $this->id = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppearance(Appearance $appearance)
    {
        $this->appearance = $appearance;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppearance()
    {
        return $this->appearance;
    }

    /**
     * {@inheritdoc}
     */
    public function setMechanics(Mechanics $mechanics)
    {
        $this->mechanics = $mechanics;
    }

    /**
     * {@inheritdoc}
     */
    public function getMechanics()
    {
        return new Mechanics();
    }

    /**
     * {@inheritdoc}
     */
    public function setEventHandlers(EventHandlers $eventHandlers)
    {
        $this->eventHandlers = $eventHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventHandlers()
    {
        return new EventHandlers();
    }

    /**
     * {@inheritdoc}
     */
    public function setRowActions(RowActions $actions)
    {
        $this->rowActions = $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowActions()
    {
        return $this->rowActions;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilters(Filters $filters)
    {
        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [];
    }
} 