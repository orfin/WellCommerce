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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Request
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Request
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Request implements RequestInterface
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
            'id',
            'starting_from',
            'limit',
            'order_by',
            'order_dir',
            'where'
        ]);

        $resolver->setDefaults([
            'id' => ''
        ]);

        $resolver->setAllowedTypes([
            'id'            => ['int', 'string'],
            'starting_from' => ['int'],
            'limit'         => ['int'],
            'order_by'      => ['string'],
            'order_dir'     => ['string'],
            'where'         => ['array']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->options['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStartingFrom()
    {
        return $this->options['starting_from'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->options['limit'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderBy()
    {
        return $this->options['order_by'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderDir()
    {
        return $this->options['order_dir'];
    }

    /**
     * {@inheritdoc}
     */
    public function getWhere()
    {
        return $this->options['where'];
    }
} 