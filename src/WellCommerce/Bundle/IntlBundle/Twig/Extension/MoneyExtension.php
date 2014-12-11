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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'money';
    }
}
