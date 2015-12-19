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

use Doctrine\ORM\Query;

/**
 * Class ArrayContext
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetContextFactory
{
    /**
     * @var DataSetContextCollection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param DataSetContextCollection $collection
     */
    public function __construct(DataSetContextCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Creates a dataset's context for given type
     *
     * @param string $type
     * @param array  $options
     *
     * @return DataSetContextInterface
     */
    public function create($type, array $options = [])
    {
        $context = $this->collection->get($type);
        $context->configure($options);

        return $context;
    }
}
