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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandlers;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filters;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Mechanics;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Routes;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\RowActions;

/**
 * Class Options
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Options
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Options implements OptionsInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'appearance',
            'mechanics',
            'event_handlers',
            'row_actions',
            'filters',
            'routes',
        ]);

        $resolver->setDefaults([
            'appearance'     => new Appearance(),
            'mechanics'      => new Mechanics(),
            'event_handlers' => new EventHandlers(),
            'row_actions'    => new RowActions(),
            'filters'        => new Filters(),
            'routes'         => new Routes(),
        ]);

        $resolver->setAllowedTypes([
            'appearance'     => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Appearance',
            'mechanics'      => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Mechanics',
            'event_handlers' => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandlers',
            'row_actions'    => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\RowActions',
            'filters'        => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filters',
            'routes'         => 'WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Routes',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        $this->options['identifier'] = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->options['identifier'];
    }

    /**
     * {@inheritdoc}
     */
    public function setAppearance(Appearance $appearance)
    {
        $this->options['appearance'] = $appearance;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppearance()
    {
        return $this->options['appearance'];
    }

    /**
     * {@inheritdoc}
     */
    public function setMechanics(Mechanics $mechanics)
    {
        $this->options['mechanics'] = $mechanics;
    }

    /**
     * {@inheritdoc}
     */
    public function getMechanics()
    {
        return $this->options['mechanics'];
    }

    /**
     * {@inheritdoc}
     */
    public function setEventHandlers(EventHandlers $eventHandlers)
    {
        $this->options['event_handlers'] = $eventHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventHandlers()
    {
        return $this->options['event_handlers'];
    }

    /**
     * {@inheritdoc}
     */
    public function setRowActions(RowActions $rowActions)
    {
        $this->options['row_actions'] = $rowActions;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowActions()
    {
        return $this->options['row_actions'];
    }

    /**
     * {@inheritdoc}
     */
    public function setFilters(Filters $filters)
    {
        $this->options['filters'] = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->options['filters'];
    }

    /**
     * {@inheritdoc}
     */
    public function setRoutes(Routes $routes)
    {
        $this->options['routes'] = $routes;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return $this->options['routes'];
    }
}