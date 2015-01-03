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

namespace WellCommerce\Bundle\CoreBundle\Form\Elements;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use WellCommerce\Bundle\CoreBundle\Form\Exception\MissingOptionException;

/**
 * Class AbstractNode
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractNode
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
    public function setOptions(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * Configures options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
            'property_path'
        ]);

        $resolver->setDefined([
            'class',
        ]);

        $resolver->setDefaults([
            'class'         => '',
            'property_path' => null,
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'label'         => 'string',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
        ]);
    }

    public function getName()
    {
        return $this->getOption('name');
    }

    /**
     * Returns elements property path
     *
     * @return null|\Symfony\Component\PropertyAccess\PropertyPath
     */
    public function getPropertyPath()
    {
        return $this->getOption('property_path');
    }

    /**
     * Sets new property path option
     *
     * @param PropertyPath $path
     */
    public function setPropertyPath(PropertyPath $path)
    {
        $this->options['property_path'] = $path;
    }

    public function hasOption($option)
    {
        return array_key_exists($option, $this->options);
    }

    public function getOption($option)
    {
        if (false === $this->hasOption($option)) {
            throw new MissingOptionException($option, get_class($this));
        }

        return $this->options[$option];
    }

    public function prepareAttributes()
    {
        return [
            'sName'  => $this->getOption('name'),
            'sLabel' => $this->getOption('label'),
            'sClass' => $this->getOption('class'),
        ];
    }
}