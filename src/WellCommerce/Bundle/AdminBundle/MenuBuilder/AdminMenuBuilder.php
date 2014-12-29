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

namespace WellCommerce\Bundle\AdminBundle\MenuBuilder;

use Symfony\Component\PropertyAccess\PropertyAccess;
use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class AdminMenuBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuBuilder extends AbstractCollection implements AdminMenuBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMenu()
    {
        $tree = $this->items['menu'];

        usort($tree, [$this, 'sortMenu']);

        return $tree;
    }

    /**
     * {@inheritdoc}
     */
    public function sortMenu(AdminMenuItemInterface $a, AdminMenuItemInterface $b)
    {
        $a->sortChildren();
        $b->sortChildren();

        if ($a->getSortOrder() == $b->getSortOrder()) {
            return 0;
        }

        return $a->getSortOrder() > $b->getSortOrder() ? 1 : -1;
    }

    /**
     * {@inheritdoc}
     */
    public function add(AdminMenuItemInterface $item)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->setValue($this->items, $item->getPath(), $item);
    }
}