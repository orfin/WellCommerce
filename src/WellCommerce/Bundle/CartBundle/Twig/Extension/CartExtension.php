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
     * Constructor
     *
     * @param CartProviderInterface        $cartProvider
     * @param CartProductProviderInterface $cartProductProvider
     */
    public function __construct(CartProviderInterface $cartProvider, CartProductProviderInterface $cartProductProvider)
    {
        $this->cartProvider        = $cartProvider;
        $this->cartProductProvider = $cartProductProvider;
    }

    public function getGlobals()
    {
        $cart     = $this->cartProvider->getCurrentCart();
        $products = $this->cartProductProvider->getProducts();

        return [
            'cart'         => $cart,
            'cartProducts' => $products
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
