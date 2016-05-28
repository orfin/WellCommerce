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

namespace WellCommerce\Bundle\SearchBundle\Document;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DocumentField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DocumentField implements DocumentFieldInterface
{
    /**
     * @var array
     */
    private $options;
    
    /**
     * DocumentField constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }
    
    public function getName() : string
    {
        return $this->options['name'];
    }
    
    public function getValue() : string
    {
        return $this->options['value'];
    }
    
    public function isIndexable() : bool
    {
        return $this->options['indexable'];
    }
    
    public function getBoost() : float
    {
        return $this->options['boost'];
    }
    
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'name',
            'value',
            'indexable',
            'boost',
        ]);
        
        $resolver->setDefault('indexable', true);
        $resolver->setDefault('boost', 1);
        
        $resolver->setAllowedTypes('name', 'string');
        $resolver->setAllowedTypes('value', 'string');
        $resolver->setAllowedTypes('indexable', 'bool');
        $resolver->setAllowedTypes('boost', ['float', 'int']);
    }
}
