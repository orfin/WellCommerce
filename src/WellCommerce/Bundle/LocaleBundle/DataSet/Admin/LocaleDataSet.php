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

namespace WellCommerce\Bundle\LocaleBundle\DataSet\Admin;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CurrencyBundle\Entity\Currency;
use WellCommerce\Bundle\LocaleBundle\Entity\Locale;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;

/**
 * Class LocaleDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
final class LocaleDataSet extends AbstractDataSet
{
    public function configureOptions(DataSetConfiguratorInterface $configurator)
    {
        $configurator->setColumns([
            'id'       => 'locale.id',
            'code'     => 'locale.code',
            'currency' => 'default_currency.code',
        ]);

        $this->setDefaultRequestOption('order_by', 'code');

        $configurator->setCacheOptions(new CacheOptions(true, 3600, [
           Locale::class,
           Currency::class
        ]));
    }
}
