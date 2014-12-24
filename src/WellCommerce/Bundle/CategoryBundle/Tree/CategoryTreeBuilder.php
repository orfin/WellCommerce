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

namespace WellCommerce\Bundle\CategoryBundle\Tree;

/**
 * Class CategoryTreeBuilder
 *
 * @package WellCommerce\Bundle\CategoryBundle\Tree
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryTreeBuilder
{
    /**
     * @var array
     */
    protected $items;

    /**
     * Constructor
     *
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    public function getTree()
    {
        $categories = $this->buildTree();

        return $categories;
    }

    private function buildTree($parent = null)
    {
        $categories = [];
        foreach ($this->items as $category) {
            if ($parent == null) {
                if ($category['parent'] != '') {
                    continue;
                }
            } elseif ($category['parent'] != $parent) {
                continue;
            }
            $categories[] = [
                'id'          => $category['id'],
                'name'        => $category['name'],
                'hasChildren' => $category['children'] > 0,
                'children'    => $this->buildTree($category['id']),
                'route'       => $category['route'],
            ];
        }

        return $categories;
    }
} 