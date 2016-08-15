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

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class TreeContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TreeContext extends ArrayContext
{
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $builder, DataSetRequestInterface $request, ColumnCollection $columns, CacheOptions $cache)
    {
        $result = parent::getResult($builder, $request, $columns, $cache);

        return $this->buildTree($result['rows'], null);
    }

    /**
     * Creates nested tree structure from result rows
     *
     * @param array $rows
     * @param null  $parent
     *
     * @return array
     */
    private function buildTree(array $rows, $parent = null)
    {
        $tree = [];

        foreach ($rows as &$row) {
            if ($row['parent'] == $parent) {
                $hasChildren        = $this->propertyAccessor->getValue($row, "[{$this->options['children_column']}]");
                $row['hasChildren'] = (bool)($hasChildren > 0);
                $row['children']    = $this->buildTree($rows, $row['id']);
                $tree[]             = $row;
            }
        }

        return $tree;
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
            'pagination'       => false
        ]);

        $resolver->setAllowedTypes('children_column', 'string');
        $resolver->setAllowedTypes('hierarchy_column', 'string');
    }
}
