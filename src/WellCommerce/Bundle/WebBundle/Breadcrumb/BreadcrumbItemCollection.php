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

namespace WellCommerce\Bundle\WebBundle\Breadcrumb;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class BreadcrumbCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class BreadcrumbItemCollection extends AbstractCollection implements BreadcrumbItemCollectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function add(BreadcrumbItemInterface $item)
    {
        $this->items[] = $item;
    }
}
