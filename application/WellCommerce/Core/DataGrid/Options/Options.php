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

    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'appearance',
            'mechanics',
            'event_handlers'
        ]);

        $resolver->setDefaults([
            'appearance'     => new Appearance(),
            'mechanics'      => new Mechanics(),
            'event_handlers' => new EventHandlers()
        ]);

        $resolver->setAllowedTypes([
            'appearance'     => 'object',
            'mechanics'      => 'object',
            'event_handlers' => 'object'
        ]);
    }

    public function setIdentifier($identifier)
    {
        $this->options['identifier'] = $identifier;
    }

    public function getIdentifier()
    {
        return $this->options['identifier'];
    }

    public function setAppearance(Appearance $appearance)
    {
        $this->options['appearance'] = $appearance;
    }

    public function getAppearance()
    {
        return $this->options['appearance'];
    }

    public function setMechanics($options)
    {
        if (!$options instanceof Mechanics) {
            $options = new Mechanics($options);
        }

        $this->options['mechanics'] = $options;
    }

    public function getMechanics()
    {
        return $this->options['mechanics'];
    }
} 