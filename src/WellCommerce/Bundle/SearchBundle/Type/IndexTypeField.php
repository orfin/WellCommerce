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

namespace WellCommerce\Bundle\SearchBundle\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class IndexTypeField
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class IndexTypeField implements IndexTypeFieldInterface
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array
     */
    private $options;
    
    /**
     * IndexTypeField constructor.
     *
     * @param string $name
     * @param array  $options
     */
    public function __construct(string $name, array $options)
    {
        $this->name = $name;
        $resolver   = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function isIndexable() : bool
    {
        return $this->options['indexable'];
    }
    
    public function isTranslatable() : bool
    {
        return $this->options['translatable'];
    }
    
    public function getBoost() : float
    {
        return $this->options['boost'];
    }

    public function getPathExpression() : string
    {
        return $this->options['path_expression'];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'indexable',
            'boost',
            'path_expression',
        ]);
        
        $resolver->setDefault('indexable', true);
        $resolver->setDefault('boost', 1);

        $resolver->setAllowedTypes('indexable', 'bool');
        $resolver->setAllowedTypes('path_expression', 'string');
        $resolver->setAllowedTypes('boost', ['float', 'int']);
    }
}
