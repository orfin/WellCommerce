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

namespace WellCommerce\Component\DataSet\Column;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Column
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class Column implements ColumnInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * Column constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    public function getAlias() : string
    {
        return $this->options['alias'];
    }

    public function getPaginatorSource() : string
    {
        return $this->options['paginator_source'];
    }

    public function getSource() : string
    {
        return $this->options['source'];
    }

    public function getRawSelect() : string
    {
        return sprintf('%s AS %s', $this->options['source'], $this->options['alias']);
    }

    public function isAggregated() : bool
    {
        return $this->options['aggregated'];
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'alias',
            'source',
            'aggregated',
            'paginator_source'
        ]);

        $resolver->setDefaults([
            'aggregated'       => false,
            'paginator_source' => '',
        ]);

        $resolver->setNormalizer('aggregated', function (Options $options) {
            return $this->isAggregateColumn($options['source'], ['SUM', 'GROUP_CONCAT', 'MIN', 'MAX', 'AVG', 'COUNT']);
        });

        $resolver->setNormalizer('paginator_source', function (Options $options) {
            return $this->normalizePaginatorSource($options);
        });
    }

    private function normalizePaginatorSource(Options $options) : string
    {
        if (true === $this->isAggregateColumn($options['source'], ['GROUP_CONCAT'])) {
            $parts = explode(' ', $options['source']);

            return $parts[1];
        }

        return $options['source'];
    }

    /**
     * Checks whether column source uses MySQL aggregate function
     *
     * @param string $source
     * @param array  $aggregates
     *
     * @return bool
     */
    private function isAggregateColumn(string $source, array $aggregates) : bool
    {
        $regex = '/(' . implode('|', $aggregates) . ')/i';

        return (bool)(preg_match($regex, $source));
    }
}
