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
     * @return \WellCommerce\CoreBundle\Component\DataSet\Context\DataSetContextInterface
     */
    public function createContext($contextType, array $options = []);

    /**
     * Creates a dataset's transformer using factory service
     *
     * @param string $transformerType
     * @param array  $options
     *
     * @return \WellCommerce\CoreBundle\Component\DataSet\Transformer\DataSetTransformerInterface
     */
    public function createTransformer($transformerType, array $options = []);

    /**
     * Creates a dataset's request using factory service
     *
     * @param array $options
     *
     * @return \WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestInterface
     */
    public function createRequest(array $options = []);
}
