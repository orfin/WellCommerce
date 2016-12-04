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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class CurrencyRate
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRate implements CurrencyRateInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    
    protected $currencyFrom = '';
    protected $currencyTo   = '';
    protected $exchangeRate = 1.0000;
    
    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }
    
    public function setCurrencyFrom(string $currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }
    
    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }
    
    public function setCurrencyTo(string $currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }
    
    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }
    
    public function setExchangeRate(float $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }
}
