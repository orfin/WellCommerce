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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractOption
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOption
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
     * Checks if key exists in options array
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->options[$key]);
    }

    /**
     * Returns option value if exists
     *
     * @param $key
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new \InvalidArgumentException(sprintf('DataGrid option key "%s" was not found.', $key));
        }

        return $this->options[$key];
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
                break;
            case OptionInterface::TYPE_NUMBER:
                return $value;
                break;
            case OptionInterface::TYPE_STRING:
                return "'" . $value . "'";
                break;
        }
    }

    /**
     * Returns string containing all DataGrid options
     *
     * @return string
     */
    public function __toString()
    {
        $attributes = [];
        foreach ($this->options as $option => $value) {
            $attributes[] = sprintf('%s: %s', $option, $this->prepareValue($value));
        }

        return implode(",\n", $attributes);
    }
}