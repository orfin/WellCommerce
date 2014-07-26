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

namespace WellCommerce\Core\DataGrid\Configuration\EventHandler;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;

/**
 * Class AbstractEventHandler
 *
 * @package WellCommerce\Core\DataGrid\Configuration\EventHandler
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractEventHandler
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
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'function',
            'callback',
            'row_action',
            'group_action',
            'context_action',
        ]);

        $resolver->setDefaults([
            'function'       => OptionInterface::GF_NULL,
            'callback'       => OptionInterface::GF_NULL,
            'row_action'     => false,
            'group_action'   => false,
            'context_action' => false,
        ]);

        $resolver->setAllowedTypes([
            'function'       => ['string', 'int'],
            'callback'       => ['string', 'int'],
            'row_action'     => ['bool', 'string'],
            'group_action'   => ['bool', 'string'],
            'context_action' => ['bool', 'string'],
        ]);
    }

    /**
     * Returns options value by its name
     *
     * @param $option
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($option)
    {
        if (!isset($this->options[$option])) {
            throw new \InvalidArgumentException(sprintf('Option "%s" does not exists.'));
        }

        return $this->options[$option];
    }
} 