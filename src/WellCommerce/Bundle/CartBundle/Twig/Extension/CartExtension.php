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

/**
 * Class CategoryExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var CartProductProviderInterface
     */
    protected $cartProductProvider;

    /**
     * Constructor
     *
     * @param CartProductProviderInterface $cartProductProvider
     */
    public function __construct(CartProductProviderInterface $cartProductProvider)
    {
        $this->cartProductProvider = $cartProductProvider;
    }

    public function getGlobals()
    {
        return [
            'cart' => [
                'products' => $this->cartProductProvider->getProducts(),
                'summary'  => $this->cartProductProvider->getSummary(),
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
