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

use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Context\DataSetContextInterface;
use WellCommerce\Component\DataSet\QueryBuilder\DataSetQueryBuilderInterface;
use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\DataSetTransformerInterface;

/**
 * Interface DataSetManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetManagerInterface
{
    /**
     * Creates a dataset's context using factory service
     *
     * @param string $contextType
     * @param array  $options
     *
     * @return DataSetContextInterface
     */
    public function createContext(string $contextType, array $options = []) : DataSetContextInterface;

    /**
     * Creates a dataset's transformer using factory service
     *
     * @param string $transformerType
     * @param array  $options
     *
     * @return DataSetTransformerInterface
     */
    public function createTransformer(string $transformerType, array $options = []) : DataSetTransformerInterface;

    /**
     * Creates a dataset's request using factory service
     *
     * @param array $options
     *
     * @return DataSetRequestInterface
     */
    public function createRequest(array $options = []) : DataSetRequestInterface;

    /**
     * Creates a QueryBuilder
     *
     * @param DataSetAwareRepositoryInterface $repository
     *
     * @return DataSetQueryBuilderInterface
     */
    public function createQueryBuilder(DataSetAwareRepositoryInterface $repository) : DataSetQueryBuilderInterface;
}
