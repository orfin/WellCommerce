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

namespace WellCommerce\Bundle\DoctrineBundle\Definition;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractMappingDefinition
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractMappingDefinition implements MappingDefinitionInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * MappingDefinition constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    abstract public function configureOptions(OptionsResolver $resolver);

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function getPropertyName()
    {
        return $this->options['fieldName'];
    }
}
