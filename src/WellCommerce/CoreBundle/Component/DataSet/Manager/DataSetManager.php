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

namespace WellCommerce\CoreBundle\Component\DataSet\Manager;

use WellCommerce\CoreBundle\Component\DataSet\Context\DataSetContextFactory;
use WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestFactory;
use WellCommerce\CoreBundle\Component\DataSet\Transformer\DataSetTransformerFactory;

/**
 * Class DataSetManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetManager implements DataSetManagerInterface
{
    /**
     * @var DataSetContextFactory
     */
    protected $contextFactory;

    /**
     * @var DataSetRequestFactory
     */
    protected $requestFactory;

    /**
     * @var DataSetTransformerFactory
     */
    protected $transformerFactory;

    /**
     * Constructor
     *
     * @param DataSetContextFactory     $contextFactory
     * @param DataSetRequestFactory     $requestFactory
     * @param DataSetTransformerFactory $transformerFactory
     */
    public function __construct(
        DataSetContextFactory $contextFactory,
        DataSetRequestFactory $requestFactory,
        DataSetTransformerFactory $transformerFactory
    ) {
        $this->contextFactory     = $contextFactory;
        $this->requestFactory     = $requestFactory;
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function createContext($contextType, array $options = [])
    {
        return $this->contextFactory->create($contextType, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createTransformer($transformerType, array $options = [])
    {
        return $this->transformerFactory->create($transformerType, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $options = [])
    {
        return $this->requestFactory->create($options);
    }
}
