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

namespace WellCommerce\Bundle\IntlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * CurrencyRate
 *
 * @ORM\Table("currency_rate")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\IntlBundle\Repository\CurrencyRateRepository")
 */
class CurrencyRate
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_from", type="string", length=12)
     */
    private $currencyFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="currency_to", type="string", length=12)
     */
    private $currencyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="exchange_rate", type="decimal", precision=15, scale=4)
     */
    private $exchangeRate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrencyFrom()
    {
        return $this->currencyFrom;
    }

    /**
     * @param string $currencyFrom
     */
    public function setCurrencyFrom($currencyFrom)
    {
        $this->currencyFrom = $currencyFrom;
    }

    /**
     * @return string
     */
    public function getCurrencyTo()
    {
        return $this->currencyTo;
    }

    /**
     * @param string $currencyTo
     */
    public function setCurrencyTo($currencyTo)
    {
        $this->currencyTo = $currencyTo;
    }

    /**
     * @return string
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @param string $exchangeRate
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }
}
