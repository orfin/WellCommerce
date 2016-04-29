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
namespace WellCommerce\Bundle\OrderBundle\Twig\Extension;

use WellCommerce\Bundle\OrderBundle\Context\Front\CartContextInterface;
use WellCommerce\Component\DataSet\DataSetInterface;

/**
 * Class CategoryExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var CartContextInterface
     */
    protected $cartContext;

    /**
     * @var DataSetInterface
     */
    protected $cartProductDataSet;

    /**
     * Constructor
     *
     * @param CartContextInterface $cartContext
     * @param DataSetInterface     $dataset
     */
    public function __construct(CartContextInterface $cartContext, DataSetInterface $dataset)
    {
        $this->cartContext        = $cartContext;
        $this->cartProductDataSet = $dataset;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('currentCart', [$this, 'getCurrentCart'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('cartProducts', [$this, 'getCurrentCartProducts'], ['is_safe' => ['html']]),
        ];
    }

    public function getCurrentCart()
    {
        if ($this->cartContext->hasCurrentCart()) {
            return $this->cartContext->getCurrentCart();
        }

        return null;
    }

    public function getCurrentCartProducts()
    {
        return $this->cartProductDataSet->getResult('array', [], ['pagination' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cart';
    }
}
