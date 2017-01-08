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

namespace WellCommerce\Component\DataSet\Manager;

use WellCommerce\Component\DataSet\Context\DataSetContextFactory;
use WellCommerce\Component\DataSet\Context\DataSetContextInterface;
use WellCommerce\Component\DataSet\QueryBuilder\DataSetQueryBuilderFactory;
use WellCommerce\Component\DataSet\QueryBuilder\DataSetQueryBuilderInterface;
use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestFactory;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection;
use WellCommerce\Component\DataSet\Transformer\DataSetTransformerFactory;
use WellCommerce\Component\DataSet\Transformer\DataSetTransformerInterface;

/**
 * Class DataSetManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class DataSetManager implements DataSetManagerInterface
{
    /**
     * @var DataSetContextFactory
     */
    private $contextFactory;
    
    /**
     * @var DataSetRequestFactory
     */
    private $requestFactory;
    
    /**
     * @var DataSetTransformerFactory
     */
    private $transformerFactory;
    
    /**
     * @var DataSetQueryBuilderFactory
     */
    private $queryBuilderFactory;
    
    /**
     * DataSetManager constructor.
     *
     * @param DataSetContextFactory      $contextFactory
     * @param DataSetRequestFactory      $requestFactory
     * @param DataSetTransformerFactory  $transformerFactory
     * @param DataSetQueryBuilderFactory $queryBuilderFactory
     */
    public function __construct(
        DataSetContextFactory $contextFactory,
        DataSetRequestFactory $requestFactory,
        DataSetTransformerFactory $transformerFactory,
        DataSetQueryBuilderFactory $queryBuilderFactory
    ) {
        $this->contextFactory      = $contextFactory;
        $this->requestFactory      = $requestFactory;
        $this->transformerFactory  = $transformerFactory;
        $this->queryBuilderFactory = $queryBuilderFactory;
    }
    
    public function createContext(string $type, array $options = [], ColumnTransformerCollection $transformers): DataSetContextInterface
    {
        $context = $this->contextFactory->create($type, $options);
        $context->setTransformers($transformers);
        
        return $context;
    }
    
    public function createTransformer(string $transformerType, array $options = []): DataSetTransformerInterface
    {
        return $this->transformerFactory->create($transformerType, $options);
    }
    
    public function createRequest(array $options = []): DataSetRequestInterface
    {
        return $this->requestFactory->create($options);
    }
    
    public function createQueryBuilder(DataSetAwareRepositoryInterface $repository): DataSetQueryBuilderInterface
    {
        return $this->queryBuilderFactory->create($repository);
    }
}
