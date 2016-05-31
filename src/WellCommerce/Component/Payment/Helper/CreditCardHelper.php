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
class CreditCardHelper implements CreditCardHelperInterface
{
    public function getCreditCardType(string $number) : string
    {
        $number = $this->clearNumber($number);

        foreach ($this->getCreditCardPatterns() as $type => $pattern) {
            if (preg_match($pattern, $number)) {
                return $type;
            }
        }

        return '';
    }

    public function isType(string $number, string $type) : bool
    {
        $pattern = $this->getCreditCardPatterns()[$type] ?? null;

        if (null === $pattern) {
            return false;
        }

        return preg_match($this->getCreditCardPatterns()[$type], $number);
    }

    public function clearNumber(string $number) : string
    {
        return preg_replace('/[^\d]/', '', $number);
    }

    public function getCreditCardPatterns() : array
    {
        return [
            self::CREDIT_CARD_TYPE_AMEX       => self::CREDIT_CARD_PATTERN_AMEX,
            self::CREDIT_CARD_TYPE_DISCOVER   => self::CREDIT_CARD_PATTERN_DISCOVER,
            self::CREDIT_CARD_TYPE_MASTERCARD => self::CREDIT_CARD_PATTERN_MASTERCARD,
            self::CREDIT_CARD_TYPE_VISA       => self::CREDIT_CARD_PATTERN_VISA,
        ];
    }
}
