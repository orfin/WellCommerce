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

namespace WellCommerce\Bundle\CoreBundle\DataSet;

use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class DataSetConfiguratorInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetConfiguratorInterface
{
    /**
     * Configures dataset
     *
     * @param DataSetInterface $dataset
     */
    public function configure(DataSetInterface $dataset);

    /**
     * Sets dataset columns
     *
     * @param array $columns
     */
    public function setColumns(array $columns = []);

    /**
     * Sets dataset transformers
     *
     * @param array $transformers
     */
    public function setTransformers(array $transformers = []);
}
