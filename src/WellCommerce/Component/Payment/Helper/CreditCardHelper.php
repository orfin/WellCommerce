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

namespace WellCommerce\Component\Payment\Helper;

/**
 * Class CreditCardHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CreditCardHelper
{
    const CREDIT_CARD_TYPE_AMEX       = 'amex';
    const CREDIT_CARD_TYPE_DISCOVER   = 'discover';
    const CREDIT_CARD_TYPE_MASTERCARD = 'mastercard';
    const CREDIT_CARD_TYPE_VISA       = 'visa';

    public function getCreditCardType(string $number) : string
    {
        $number = $this->clearNumber($number);

        foreach ($this->getPatterns() as $type => $pattern) {
            if (preg_match($pattern, $number)) {
                return $type;
            }
        }

        return '';
    }

    public function isAmex(string $number) : bool
    {
        return preg_match($this->getPatterns()[self::CREDIT_CARD_TYPE_AMEX], $number);
    }

    public function isDiscover(string $number) : bool
    {
        return preg_match($this->getPatterns()[self::CREDIT_CARD_TYPE_DISCOVER], $number);
    }

    public function isMasterCard(string $number) : bool
    {
        return preg_match($this->getPatterns()[self::CREDIT_CARD_TYPE_MASTERCARD], $number);
    }

    public function isVisa(string $number) : bool
    {
        return preg_match($this->getPatterns()[self::CREDIT_CARD_TYPE_VISA], $number);
    }

    private function clearNumber(string $number) : string
    {
        return preg_replace('/[^\d]/', '', $number);
    }

    private function getPatterns() : array
    {
        return [
            self::CREDIT_CARD_TYPE_AMEX       => '/^3[47][0-9]{13}$/',
            self::CREDIT_CARD_TYPE_DISCOVER   => '/^6(?:011|5[0-9][0-9])[0-9]{12}$/',
            self::CREDIT_CARD_TYPE_MASTERCARD => '/^5[1-5][0-9]{14}$/',
            self::CREDIT_CARD_TYPE_VISA       => '/^4[0-9]{12}(?:[0-9]{3})?$/',
        ];
    }
}
