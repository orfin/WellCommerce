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

namespace WellCommerce\Component\DataSet\Transformer;

/**
 * Class TransformerCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetTransformerFactory
{
    /**
     * @var DataSetTransformerCollection
     */
    protected $transformers;

    /**
     * Constructor
     *
     * @param DataSetTransformerCollection $transformers
     */
    public function __construct(DataSetTransformerCollection $transformers)
    {
        $this->transformers = $transformers;
    }

    public function create($type, array $options = [])
    {
        $transformer = $this->transformers->get($type);
        $transformer->configure($options);

        return $transformer;
    }
}
