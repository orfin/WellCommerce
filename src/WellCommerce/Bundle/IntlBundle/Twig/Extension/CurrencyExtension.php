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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use WellCommerce\Bundle\IntlBundle\Provider\CurrencyProviderInterface;

/**
 * Class CurrencyExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var CurrencyProviderInterface
     */
    protected $provider;

    /**
     * Constructor
     *
     * @param RequestStack              $requestStack
     * @param CurrencyProviderInterface $provider
     */
    public function __construct(RequestStack $requestStack, CurrencyProviderInterface $provider)
    {
        $this->requestStack = $requestStack;
        $this->provider     = $provider;
    }

    public function getGlobals()
    {
        return [
            'currencies' => $this->provider->getSelect()
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('money', [$this, 'getMoney'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('price', [$this, 'formatPrice'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'currency';
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
        $locale    = $this->requestStack->getMasterRequest()->getLocale();
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);

        if (false === $result = $formatter->formatCurrency($price, $currency)) {
            $e = sprintf('Cannot format price with amount "%s" and currency "%s"', $price, $currency);
            throw new \InvalidArgumentException($e);
        }

        return $result;
    }
}
