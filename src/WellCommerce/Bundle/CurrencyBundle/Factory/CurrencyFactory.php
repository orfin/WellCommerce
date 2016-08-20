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

namespace WellCommerce\Bundle\CurrencyBundle\Factory;

use WellCommerce\Bundle\CurrencyBundle\Entity\Currency;
use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;

/**
 * Class CurrencyFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFactory extends AbstractEntityFactory
{
    public function create() : CurrencyInterface
    {
        $currency = new Currency();
        $currency->setEnabled(true);
        $currency->setCode('');

        return $currency;
    }
}
