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

namespace WellCommerce\Component\DataSet\Context;

/**
 * Class DataSetContextFactory
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetContextFactory
{
    /**
     * @var DataSetContextCollection
     */
    private $collection;

    /**
     * Constructor
     *
     * @param DataSetContextCollection $collection
     */
    public function __construct(DataSetContextCollection $collection)
    {
        $this->collection = $collection;
    }

    public function create(string $type, array $options = []) : DataSetContextInterface
    {
        $context = $this->collection->get($type);
        $context->configure($options);

        return $context;
    }
}
