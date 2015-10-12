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

use WellCommerce\Bundle\CartBundle\Provider\CartProviderInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;

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
     * @var DataSetInterface
     */
    protected $cartProductDataSet;

    /**
     * Constructor
     *
     * @param CartProviderInterface $cartProvider
     * @param DataSetInterface      $dataset
     */
    public function __construct(CartProviderInterface $cartProvider, DataSetInterface $dataset)
    {
        $this->cartProvider       = $cartProvider;
        $this->cartProductDataSet = $dataset;
    }

    public function getGlobals()
    {
        return [
            'cart'         => $this->cartProvider->getCurrentResource(),
            'cartProducts' => $this->cartProductDataSet->getResult('array')
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
