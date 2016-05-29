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

namespace WellCommerce\Component\Search\Model;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Field
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Field implements FieldInterface
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
     * @var string
     */
    private $value;

    /**
     * Field constructor.
     *
     * @param string $name
     * @param array  $options
     */
    public function __construct(string $name, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
        $this->name    = $name;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getValue() : string
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }
    
    public function isIndexable() : bool
    {
        return $this->options['indexable'];
    }
    
    public function getBoost() : float
    {
        return $this->options['boost'];
    }

    public function getFuzziness() : float
    {
        return $this->options['fuzziness'];
    }

    public function getValueExpression() : string
    {
        return $this->options['value_expression'];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'indexable',
            'boost',
            'fuzziness',
            'value_expression',
        ]);
        
        $resolver->setDefault('indexable', true);
        $resolver->setDefault('boost', 1);
        $resolver->setDefault('fuzziness', 1);

        $resolver->setAllowedTypes('indexable', 'bool');
        $resolver->setAllowedTypes('boost', ['float', 'int']);
        $resolver->setAllowedTypes('fuzziness', ['float', 'int']);
        $resolver->setAllowedTypes('value_expression', 'string');
    }
}
