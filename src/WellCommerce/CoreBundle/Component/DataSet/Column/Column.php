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

namespace WellCommerce\CoreBundle\Component\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Column
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column implements ColumnInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'alias',
            'source',
            'aggregated'
        ]);

        $resolver->setDefaults([
            'aggregated' => false
        ]);

        $resolver->setNormalizers([
            'aggregated' => function ($options) {
                return $this->isAggregateColumn($options['source']);
            },
        ]);
    }

    /**
     * Checks whether column source uses MySQL aggregate function
     *
     * @param string $source
     *
     * @return bool
     */
    protected function isAggregateColumn($source)
    {
        $aggregates = ['SUM', 'GROUP_CONCAT', 'MIN', 'MAX', 'AVG', 'COUNT'];
        $regex      = '/(' . implode('|', $aggregates) . ')/i';

        return (bool)(preg_match($regex, $source));
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->options['alias'];
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
        return sprintf('%s AS %s', $this->options['source'], $this->options['alias']);
    }

    /**
     * {@inheritdoc}
     */
    public function isAggregated()
    {
        return $this->options['aggregated'];
    }
}
