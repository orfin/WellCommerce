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

namespace WellCommerce\Bundle\CurrencyBundle\Entity;

/**
 * Class CurrencyAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait CurrencyAwareTrait
{
    /**
     * @var CurrencyInterface
     */
    protected $currency;

    /**
     * @return CurrencyInterface
     */
    public function getCurrency() : CurrencyInterface
    {
        return $this->currency;
    }

    /**
     * @param CurrencyInterface $currency
     */
    public function setCurrency(CurrencyInterface $currency)
    {
        $this->currency = $currency;
    }
}
