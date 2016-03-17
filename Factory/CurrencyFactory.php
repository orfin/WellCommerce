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

use WellCommerce\Bundle\CurrencyBundle\Entity\CurrencyInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CurrencyFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFactory extends AbstractEntityFactory
{
    /**
     * @var string
     */
    protected $supportsInterface = CurrencyInterface::class;

    /**
     * @return CurrencyInterface
     */
    public function create() : CurrencyInterface
    {
        /** @var $currency CurrencyInterface */
        $currency = $this->init();
        $currency->setEnabled(true);
        $currency->setCode('');

        return $currency;
    }
}
