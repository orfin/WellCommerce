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
 * Class Options
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Options implements OptionsInterface
{
    /**
     * @var array
     */
    protected $options;

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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'appearance',
            'mechanics',
            'event_handlers',
        ]);

        $resolver->setDefaults([
            'appearance'     => new Appearance(),
            'mechanics'      => new Mechanics(),
            'event_handlers' => new EventHandlers(),
        ]);

        $resolver->setAllowedTypes('appearance', Appearance::class);
        $resolver->setAllowedTypes('mechanics', Mechanics::class);
        $resolver->setAllowedTypes('event_handlers', EventHandlers::class);
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier(string $identifier)
    {
        $this->options['identifier'] = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier() : string
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
    public function getAppearance() : Appearance
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
    public function getMechanics() : Mechanics
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
    public function getEventHandlers() : EventHandlers
    {
        return $this->options['event_handlers'];
    }
}
