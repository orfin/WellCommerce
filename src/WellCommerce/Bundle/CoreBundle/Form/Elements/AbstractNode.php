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
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;

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
        ]);

        $resolver->setDefined([
            'class'
        ]);

        $resolver->setDefaults([
            'property_path' => null,
            'class'         => '',
        ]);

        $resolver->setNormalizer('property_path', function ($options) {
            return new PropertyPath($options['name']);
        });

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'class'         => 'string',
            'label'         => 'string',
            'property_path' => ['null', 'Symfony\Component\PropertyAccess\PropertyPath'],
        ]);

    }

    public function getName()
    {
        return $this->getOption('name');
    }

    public function getPropertyPath()
    {
        return $this->getOption('property_path');
    }

    public function hasOption($option)
    {
        return isset($this->options[$option]);
    }

    public function getOption($option)
    {
        if (!$this->hasOption($option)) {
            throw new \InvalidArgumentException(sprintf('Option "%s" does not exists', $option));
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

    /**
     * Returns property accessor
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
}