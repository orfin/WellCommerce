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

namespace WellCommerce\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractOption
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOption implements OptionInterface
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
    
    /**
     * {@inheritdoc}
     */
    abstract public function configureOptions(OptionsResolver $resolver);
    
    public function has(string $key) : bool
    {
        return isset($this->options[$key]);
    }
    
    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException(sprintf('DataGrid option key "%s" was not found.', $key));
        }
        
        return $this->options[$key];
    }
    
    public function set(string $key, $value)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException(sprintf('DataGrid option key "%s" was not found.', $key));
        }
        
        $this->options[$key] = $value;
    }
    
    /**
     * Prepares value to use in DataGrid JS configuration
     *
     * @param $value
     *
     * @return string
     */
    protected function prepareValue($value)
    {
        switch (gettype($value)) {
            case OptionInterface::TYPE_BOOLEAN:
                return ($value) ? 'true' : 'false';
            case OptionInterface::TYPE_NUMBER:
                return $value;
            case OptionInterface::TYPE_STRING:
                return "'" . $value . "'";
        }
    }
    
    /**
     * Returns string containing all DataGrid options
     *
     * @return string
     */
    public function __toString() : string
    {
        $attributes = [];
        foreach ($this->options as $option => $value) {
            $attributes[] = sprintf('%s: %s', $option, $this->prepareValue($value));
        }
        
        return implode(",\n", $attributes);
    }
}
