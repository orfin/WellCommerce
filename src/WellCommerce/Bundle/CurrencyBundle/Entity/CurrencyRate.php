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
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class CurrencyRate
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRate extends AbstractEntity implements CurrencyRateInterface
{
    use Timestampable;
    use Blameable;
    
    /**
     * @var CurrencyInterface
     */
    protected $currencyFrom;
    
    /**
     * @var CurrencyInterface
     */
    protected $currencyTo;
    
    /**
     * @var float
     */
    protected $exchangeRate;
    
    /**
     * {@inheritdoc}
     */
    public function getCurrencyFrom() : string
    {
        return $this->currencyFrom;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCurrencyFrom(string $currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCurrencyTo() : string
    {
        return $this->currencyTo;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCurrencyTo(string $currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExchangeRate() : float
    {
        return $this->exchangeRate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExchangeRate(float $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }
}
