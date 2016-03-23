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

namespace WellCommerce\Bundle\ProductStatusBundle\Context\Front;

use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class ProductStatusContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusContext implements ProductStatusContextInterface
{
    /**
     * @var ProductStatusInterface
     */
    protected $currentProductStatus;

    /**
     * {@inheritdoc}
     */
    public function setCurrentProductStatus(ProductStatusInterface $productStatus)
    {
        $this->currentProductStatus = $productStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProductStatus() : ProductStatusInterface
    {
        return $this->currentProductStatus;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCurrentProductStatusIdentifier() : int
    {
        return $this->getCurrentProductStatus()->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProductStatus() : bool
    {
        return $this->currentProductStatus instanceof ProductStatusInterface;
    }

}
