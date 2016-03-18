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

namespace WellCommerce\Component\DataSet\Provider;

use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\DataSet\Exception\MissingDataSetException;

/**
 * Class ResourceProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetProvider implements DataSetProviderInterface
{
    /**
     * @var DataSetInterface|null $dataset
     */
    protected $dataset;

    /**
     * @var array
     */
    protected $defaultContextOptions;

    /**
     * @var array
     */
    protected $defaultRequestOptions;

    /**
     * Constructor
     *
     * @param DataSetInterface|null $dataset
     */
    public function __construct(DataSetInterface $dataset = null)
    {
        $this->dataset = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSet()
    {
        if (null === $this->dataset) {
            throw new MissingDataSetException(get_class($this));
        }

        return $this->dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult($contextType, array $contextOptions = [], array $requestOptions = [])
    {
        $contextOptions = array_merge($this->defaultContextOptions, $contextOptions);
        $requestOptions = array_merge($this->defaultRequestOptions, $requestOptions);

        return $this->getDataSet()->getResult($contextType, $contextOptions, $requestOptions);
    }
}
