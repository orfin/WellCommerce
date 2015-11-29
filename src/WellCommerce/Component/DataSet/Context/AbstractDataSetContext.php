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
use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection;

/**
 * Class AbstractDataSetContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetContext
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * {@inheritdoc}
     */
    public function configure(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options          = $optionsResolver->resolve($options);
        $this->propertyAccessor = $this->getPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $query  = $queryBuilder->getQuery();
        $result = $query->getArrayResult();
        $result = $this->transformResult($result);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'column_transformers',
        ]);

        $resolver->setDefaults([
            'column_transformers' => new ColumnTransformerCollection(),
        ]);

        $resolver->setAllowedTypes([
            'column_transformers' => ['WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection'],
        ]);
    }

    /**
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * @return ColumnTransformerCollection
     */
    protected function getTransformers()
    {
        return $this->options['column_transformers'];
    }

    /**
     * Transforms the results using additional data transformers
     *
     * @param array $result
     *
     * @return array
     */
    protected function transformResult(array $result)
    {
        $transformers = $this->getTransformers();

        if ($transformers->count()) {
            foreach ($result as $index => $row) {
                $result[$index] = $this->transformRow($row, $transformers);
            }
        }

        return $result;
    }

    /**
     * Processes the row data
     *
     * @param array $row
     *
     * @return array
     */
    protected function transformRow($row, ColumnTransformerCollection $transformers)
    {
        foreach ($row as $field => $value) {
            if ($transformers->has($field)) {
                $row[$field] = $transformers->get($field)->transformValue($value);
            }
        }

        return $row;
    }
}
