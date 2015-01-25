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

namespace WellCommerce\Bundle\DataSetBundle\CollectionBuilder;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TreeBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class TreeBuilder extends FlatTreeBuilder
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'parent_identifier',
        ]);

        $resolver->setDefaults([
            'parent_identifier' => 'parent',
        ]);

        $resolver->setAllowedTypes([
            'parent_identifier' => 'string',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        $rows = $this->getDataSetRows();
        $tree = $this->buildTree($rows, null);

        return $tree;
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

        foreach ($rows as $row) {
            if ($row['parent'] == $parent) {
                $tree[] = [
                    'id'          => $row['id'],
                    'name'        => $row['name'],
                    'hasChildren' => $row['children'] > 0,
                    'children'    => $this->buildTree($rows, $row['id']),
                    'route'       => $row['route'],
                ];
            }
        }

        return $tree;
    }
}
