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

use Symfony\Component\OptionsResolver\Options;
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
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'label',
        ]);

        $resolver->setDefined([
            'class'
        ]);

        $resolver->setDefaults([
            'class'        => '',
        ]);

        $resolver->setAllowedTypes([
            'name'          => 'string',
            'class'         => 'string',
            'label'         => 'string',
        ]);

    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->options['name'];
    }

    /**
     * Returns label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->options['label'];
    }

    /**
     * Returns CSS class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->options['class'];
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

    public function prepareAttributesJs()
    {
        return [
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('class', 'sClass'),
            $this->formatAttributeJs('label', 'sLabel'),
        ];

        return $attributes;
    }
}