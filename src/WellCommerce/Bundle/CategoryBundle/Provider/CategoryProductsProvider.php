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
 * Class CategoryProductsProvider
 *
 * @package WellCommerce\Bundle\CategoryBundle\Provider
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryProductsProvider implements ProviderInterface
{
    protected $resource;

    public function getType()
    {
        return 'category_products';
    }

    public function setCurrentResource($resource)
    {
        $this->resource = $resource;
    }

    public function getCurrentResource()
    {
        return $this->resource;
    }
}
