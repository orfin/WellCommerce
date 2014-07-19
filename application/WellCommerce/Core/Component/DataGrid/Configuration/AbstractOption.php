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

namespace WellCommerce\Core\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractOption
 *
 * @package WellCommerce\Core\Component\DataGrid\Configuration
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
}