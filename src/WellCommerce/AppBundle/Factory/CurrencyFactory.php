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

namespace WellCommerce\AppBundle\Factory;

use WellCommerce\AppBundle\Entity\Currency;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class CurrencyFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFactory extends AbstractFactory
{
    /**
     * @return \WellCommerce\AppBundle\Entity\CurrencyInterface
     */
    public function create()
    {
        $currency = new Currency();
        $currency->setCode('');

        return $currency;
    }
}
