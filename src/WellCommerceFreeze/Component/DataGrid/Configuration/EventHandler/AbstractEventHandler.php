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

namespace WellCommerce\Component\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataGrid\Configuration\OptionInterface;

/**
 * Class AbstractEventHandler
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEventHandler implements EventHandlerInterface
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
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'function',
        ]);

        $resolver->setDefaults([
            'function' => OptionInterface::GF_NULL,
        ]);

        $resolver->setAllowedTypes('function', ['string', 'int']);
    }

    /**
     * Returns options value by its name
     *
     * @param string $option
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get(string $option)
    {
        if (!isset($this->options[$option])) {
            throw new \InvalidArgumentException(sprintf('Option "%s" does not exists.', $option));
        }

        return $this->options[$option];
    }

    /**
     * Checks whether event handler has passed option
     *
     * @param $option
     *
     * @return bool
     */
    public function has(string $option) : bool
    {
        return isset($this->options[$option]);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function isCustomEvent() : bool
    {
        return false;
    }
}
