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

namespace WellCommerce\CommonBundle\DataSet\Admin;

use WellCommerce\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class CurrencyDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyDataSet extends AbstractDataSet
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'   => 'currency.id',
            'code' => 'currency.code',
        ]);

        $this->setDefaultRequestOption('order_by', 'code');
    }
}
