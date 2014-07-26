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

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Core\DataGrid\Configuration\Appearance;
use WellCommerce\Core\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\DataGrid\Configuration\Mechanics;
use WellCommerce\Core\DataGrid\Configuration\RowActions;

/**
 * Class Options
 *
 * @package WellCommerce\Core\DataGrid\Options
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
            'row_actions'
        ]);

        $resolver->setDefaults([
            'appearance'     => new Appearance(),
            'mechanics'      => new Mechanics(),
            'event_handlers' => new EventHandlers(),
            'row_actions'    => new RowActions()
        ]);

        $resolver->setAllowedTypes([
            'appearance'     => 'object',
            'mechanics'      => 'object',
            'event_handlers' => 'object',
            'row_actions'    => 'object'
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
} 