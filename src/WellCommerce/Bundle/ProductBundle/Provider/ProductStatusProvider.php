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

use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;
use WellCommerce\Bundle\ProductBundle\Entity\ProductStatus;

/**
 * Class ProductStatusProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusProvider extends AbstractProvider implements ProductStatusProviderInterface
{
    /**
     * @var ProductStatus
     */
    protected $productStatus;

    /**
     * {@inheritdoc}
     */
    public function setCurrentProductStatus(ProductStatus $productStatus)
    {
        $this->productStatus = $productStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProductStatus()
    {
        return $this->productStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentProductStatusId()
    {
        if(null === $this->productStatus){
            throw new \LogicException('Cannot use this method before current status in provider is set.');
        }

        return $this->productStatus->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentProductStatus()
    {
        return (null !== $this->productStatus);
    }
}
