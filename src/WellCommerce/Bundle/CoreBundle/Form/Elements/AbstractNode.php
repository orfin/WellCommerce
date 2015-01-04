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
use WellCommerce\Bundle\CoreBundle\Form\Exception\TransformerNotFoundException;

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
     * {@inheritdoc}
     */
    public function setOptions(array $options = [])
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getOption('name');
    }

    /**
     * Checks whether element has property_path option
     *
     * @return bool
     */
    public function hasPropertyPath()
    {
        return isset($this->options['property_path']);
    }

    /**
     * {@inheritdoc}
     */
    public function getPropertyPath()
    {
        return $this->getOption('property_path');
    }

    /**
     * {@inheritdoc}
     */
    public function hasTransformer()
    {
        return isset($this->options['transformer']);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransformer()
    {
        if (!$this->hasTransformer()) {
            throw new TransformerNotFoundException($this->getName(), get_class($this));
        }

        return $this->getOption('transformer');
    }

    /**
     * {@inheritdoc}
     */
    public function hasOption($option)
    {
        return isset($this->options[$option]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * {@inheritdoc}
     */
    public function prepareAttributes()
    {
        return [
            'sName'  => $this->getOption('name'),
            'sLabel' => $this->getOption('label'),
            'sClass' => $this->getOption('class'),
        ];
    }

    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }
}