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

namespace WellCommerce\Bundle\IntlBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;

/**
 * Class CurrencyProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyProvider extends AbstractProvider implements CurrencyProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSelect()
    {
        $options = [
            'value_key' => 'code',
            'label_key' => 'code',
            'order_by'  => 'code',
        ];

        return $this->getCollectionBuilder()->getSelect($options);
    }
}
