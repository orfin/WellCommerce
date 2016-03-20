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

namespace WellCommerce\Component\DataSet\Configurator;

use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\DataSetInterface;

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
     * Simplifies adding new column transformers as default context options
     *
     * @param array $transformers
     */
    public function setColumnTransformers(array $transformers = []);

    /**
     * Sets the dataset's cache configuration
     *
     * @param CacheOptions $options
     *
     * @return mixed
     */
    public function setCacheOptions(CacheOptions $options);
}
