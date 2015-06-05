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

namespace WellCommerce\Bundle\CoreBundle\Provider;

use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\CollectionBuilderFactoryInterface;

/**
 * Interface ProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProviderInterface
{
    /**
     * Sets collection builder
     *
     * @param CollectionBuilderFactoryInterface $collectionBuilderFactoryInterface
     */
    public function setCollectionBuilder(CollectionBuilderFactoryInterface $collectionBuilderFactoryInterface);

    /**
     * Returns related collection builder
     *
     * @return CollectionBuilderFactoryInterface
     */
    public function getCollectionBuilder();
}
