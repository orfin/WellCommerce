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

/**
 * Class CurrencyRate
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyRate implements CurrencyRateInterface
{
    use Timestampable;
    use Blameable;
    
    /**
     * @var integer
     */
    protected $id;
    
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
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCurrencyFrom($currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCurrencyTo()
    {
        return $this->currencyTo;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCurrencyTo($currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = (float)$exchangeRate;
    }
}
