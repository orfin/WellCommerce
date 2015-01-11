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

namespace WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FlatTreeBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FlatTreeBuilder extends AbstractDataSetCollectionBuilder implements DataSetCollectionBuilder
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'order_by',
        ]);

        $resolver->setDefaults([
            'limit'     => 100,
            'order_by'  => 'hierarchy',
            'order_dir' => 'asc',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $rows = $this->getDataSetRows();

        return $this->makeTree($rows);
    }

    /**
     * Creates flat tree structure from result rows
     *
     * @param array $rows
     *
     * @return array
     */
    private function makeTree(array $rows)
    {
        $tree = [];

        foreach ($rows as $row) {
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
    private function makeNode($row, &$tree)
    {
        $tree[$row['id']] = [
            'id'          => $row['id'],
            'name'        => $row['name'],
            'slug'        => $row['slug'],
            'hasChildren' => (bool) ($row['children'] > 0),
            'parent'      => $row['parent'],
            'weight'      => $row['hierarchy'],
        ];
    }
}
