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

namespace WellCommerce\Bundle\CategoryBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface CategoryProviderInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryProviderInterface extends ProviderInterface
{
    const CATEGORY_TREE_LIMIT = 10;
    const CATEGORY_ORDER_BY   = 'name';
    const CATEGORY_ORDER_DIR  = 'asc';

    public function getCategoriesTree(
        $limit = self::CATEGORY_TREE_LIMIT,
        $orderBy = self::CATEGORY_ORDER_BY,
        $orderDir = self::CATEGORY_ORDER_DIR
    );
}