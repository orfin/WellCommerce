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
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class FlatTreeContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FlatTreeContext extends AbstractDataSetContext implements DataSetContextInterface
{
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $result = parent::getResult($queryBuilder, $request, $columns);

        return $this->makeTree($result);
    }

    /**
     * Creates flat tree structure from result rows
     *
     * @param array $result
     *
     * @return array
     */
    private function makeTree(array $result)
    {
        $tree = [];

        foreach ($result as $row) {
            $this->makeNode($row, $tree);
        }

        return $tree;
    }

    /**
     * Converts single row to flat-tree node
     *
     * @param array $row
     * @param array $tree
     */
    private function makeNode(&$row, &$tree)
    {
        $hasChildren = $this->propertyAccessor->getValue($row, "[{$this->options['children_column']}]");
        $weight      = $this->propertyAccessor->getValue($row, "[{$this->options['hierarchy_column']}]");

        $row['hasChildren'] = (bool)($hasChildren > 0);
        $row['weight']      = $weight;
        $tree[$row['id']]   = $row;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'children_column',
            'hierarchy_column',
        ]);

        $resolver->setDefaults([
            'children_column'  => 'children',
            'hierarchy_column' => 'hierarchy',
        ]);

        $resolver->setAllowedTypes('children_column', 'string');
        $resolver->setAllowedTypes('hierarchy_column', 'string');
    }
}
