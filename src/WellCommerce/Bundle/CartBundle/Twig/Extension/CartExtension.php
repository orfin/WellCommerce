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

use WellCommerce\Bundle\CartBundle\Helper\CartHelperInterface;

/**
 * Class CartExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartExtension extends \Twig_Extension
{
    /**
     * @var CartHelperInterface
     */
    protected $cartHelper;

    /**
     * @param CartHelperInterface $cartHelper
     */
    public function __construct(CartHelperInterface $cartHelper)
    {
        $this->cartHelper = $cartHelper;
    }

    public function getGlobals()
    {
        return ['cart' => $this->cartHelper->getCart()];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cart';
    }
}
