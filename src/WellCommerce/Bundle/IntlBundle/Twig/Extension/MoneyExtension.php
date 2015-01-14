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
namespace WellCommerce\Bundle\IntlBundle\Twig\Extension;

use Money\Money;

/**
 * Class MoneyExtension
 *
 * @package WellCommerce\Bundle\IntlBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MoneyExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('money', [$this, 'getMoney'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns formatted amount
     *
     * @param Money $money
     *
     * @return int
     */
    public function getMoney(Money $money)
    {
        return $money->getAmount();
    }

    public function formatPrice($price, $currency)
    {
        $formatter = new \NumberFormatter(\Locale::getDefault(), \NumberFormatter::CURRENCY);

        if (false === $result = $formatter->formatCurrency($price, $currency)) {
            $e = sprintf('Cannot format price with amount "%s" and currency "%s"', $price, $currency);
            throw new \InvalidArgumentException($e);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'money';
    }
}
