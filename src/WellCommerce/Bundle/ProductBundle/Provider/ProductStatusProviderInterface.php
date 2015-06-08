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

namespace WellCommerce\Bundle\ProductBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductStatus;

/**
 * Interface ProductStatusProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductStatusProviderInterface extends ProviderInterface
{
    /**
     * Sets currently viewed product status
     *
     * @param Product $product
     */
    public function setCurrentProductStatus(ProductStatus $product);

    /**
     * Returns an instance of currently viewed product status
     *
     * @return ProductStatus
     */
    public function getCurrentProductStatus();

    /**
     * Checks whether provider contains product status object
     *
     * @return bool
     */
    public function hasCurrentProductStatus();

    /**
     * Returns current status id if set. Throws LogicException otherwise.
     *
     * @return int
     */
    public function getCurrentProductStatusId();
}
