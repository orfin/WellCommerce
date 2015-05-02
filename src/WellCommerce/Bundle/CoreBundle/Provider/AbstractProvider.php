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
 * Class AbstractProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var object
     */
    protected $resource;

    /**
     * @var CollectionBuilderFactoryInterface
     */
    protected $collectionBuilderFactory;

    /**
     * Constructor
     *
     * @param CollectionBuilderFactoryInterface $collectionBuilderFactory
     */
    public function __construct(CollectionBuilderFactoryInterface $collectionBuilderFactory)
    {
        $this->collectionBuilderFactory = $collectionBuilderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionBuilder()
    {
        return $this->collectionBuilderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentResource()
    {
        return $this->resource;
    }
}