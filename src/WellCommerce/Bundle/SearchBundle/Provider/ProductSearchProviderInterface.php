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

namespace WellCommerce\Bundle\SearchBundle\Provider;

use WellCommerce\Bundle\SearchBundle\Query\SimpleQuery;

/**
 * Interface SearchProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchProviderInterface
{
    /**
     * @param SimpleQuery $query
     *
     * @return SearchProviderInterface
     */
    public function searchProducts(SimpleQuery $query);

    /**
     * @return array
     */
    public function getResultIdentifiers();
}
