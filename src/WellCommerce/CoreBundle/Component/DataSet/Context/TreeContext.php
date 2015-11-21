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

namespace WellCommerce\CoreBundle\Component\DataSet\Context;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnCollection;
use WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class TreeContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TreeContext extends FlatTreeContext
{
    /**
     * {@inheritdoc}
     */
    public function getResult(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $result = parent::getResult($queryBuilder, $request, $columns);

        return $this->buildTree($result, null);
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
            'parent_column',
        ]);

        $resolver->setDefaults([
            'parent_column' => 'parent',
        ]);

        $resolver->setAllowedTypes([
            'parent_column' => 'string',
        ]);
    }
}
