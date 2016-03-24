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

namespace WellCommerce\Component\DataSet\Context;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class SelectContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class SelectContext extends ArrayContext
{
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache)
    {
        $result = parent::getResult($builder, $request, $columns, $cache);

        return $this->makeOptions($result['rows']);
    }

    /**
     * Processes dataset rows as select options
     *
     * @param array $result
     *
     * @return array
     */
    private function makeOptions(array $result)
    {
        $options = [];

        foreach ($result as $row) {
            $this->makeOption($row, $options);
        }

        return $options;
    }

    /**
     * Processes single row
     *
     * @param $row
     * @param $options
     */
    private function makeOption($row, &$options)
    {
        $value           = $this->propertyAccessor->getValue($row, "[{$this->options['value_column']}]");
        $label           = $this->propertyAccessor->getValue($row, "[{$this->options['label_column']}]");
        $options[$value] = $label;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'value_column',
            'label_column',
        ]);

        $resolver->setDefaults([
            'value_column' => 'id',
            'label_column' => 'name',
            'pagination'   => false
        ]);

        $resolver->setAllowedTypes('value_column', 'string');
        $resolver->setAllowedTypes('label_column', 'string');
    }
}
