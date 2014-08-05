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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Column
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column implements ColumnInterface
{
    /**
     * Column options
     *
     * @var array
     */
    private $options = [];

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'id',
            'source',
        ]);

        $resolver->setOptional([
            'process_function',
            'aggregated'
        ]);

        $resolver->setAllowedTypes([
            'id'               => 'string',
            'source'           => 'string',
            'process_function' => 'string',
            'aggregated'       => 'bool'
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
    public function getSource()
    {
        return $this->options['source'];
    }

    /**
     * {@inheritdoc}
     */
    public function getRawSelect()
    {
        return sprintf('%s AS %s', $this->getSource(), $this->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function isAggregated()
    {
        return $this->options['aggregated'];
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessFunction()
    {
        return $this->options['process_function'];
    }
} 