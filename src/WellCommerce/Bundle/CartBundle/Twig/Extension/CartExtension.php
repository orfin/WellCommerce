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
namespace WellCommerce\Bundle\CartBundle\Twig\Extension;

use WellCommerce\Bundle\CartBundle\Provider\CartProductProviderInterface;
use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\CartBundle\Provider\CartSummaryProviderInterface;

/**
 * Class CategoryExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var CartProviderInterface
     */
    protected $cartProvider;

    /**
     * @var CartProductProviderInterface
     */
    protected $cartProductProvider;

    /**
     * @var CartSummaryProviderInterface
     */
    protected $cartSummaryProvider;

    /**
     * Constructor
     *
     * @param CartProviderInterface        $cartProvider
     * @param CartProductProviderInterface $cartProductProvider
     * @param CartSummaryProviderInterface $cartSummaryProvider
     */
    public function __construct(
        CartProviderInterface $cartProvider,
        CartProductProviderInterface $cartProductProvider,
        CartSummaryProviderInterface $cartSummaryProvider
    ) {
        $this->cartProvider        = $cartProvider;
        $this->cartProductProvider = $cartProductProvider;
        $this->cartSummaryProvider = $cartSummaryProvider;
    }

    public function getGlobals()
    {
        return [
            'cart' => [
                'products' => $this->cartProductProvider->getProducts(),
                'summary'  => $this->cartSummaryProvider->getTotals()
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cart';
    }
}
