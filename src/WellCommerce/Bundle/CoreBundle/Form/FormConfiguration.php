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

namespace WellCommerce\Bundle\CoreBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FormConfiguration
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormConfiguration implements FormConfigurationInterface
{
    /**
     * @var array Form configuration options
     */
    protected $options;

    /**
     * Constructor
     *
     * @param $options
     */
    public function __construct($options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name'
        ]);

        $resolver->setDefined([
            'class',
            'action',
            'method',
            'tabs',
        ]);

        $resolver->setDefaults([
            'action' => '',
            'class'  => '',
            'method' => FormConfigurationInterface::FORM_METHOD,
            'tabs'   => FormConfigurationInterface::TABS_VERTICAL,
        ]);

        $resolver->setAllowedTypes([
            'class'  => 'string',
            'action' => 'string',
            'method' => 'string',
            'tabs'   => 'integer'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAction()
    {
        return $this->options['action'];
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->options['class'];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->options['method'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTabs()
    {
        return $this->options['tabs'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->options['name'];
    }
} 