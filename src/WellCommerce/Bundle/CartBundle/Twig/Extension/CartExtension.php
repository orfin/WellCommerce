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
use WellCommerce\Bundle\CategoryBundle\Provider\CategoryProviderInterface;

/**
 * Class CategoryExtension
 *
 * @package WellCommerce\Bundle\CategoryBundle\Twig\Extension
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

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cart', [$this, 'getCart'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cart';
    }

    /**
     * Returns categories tree
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return array
     */
    public function getCart()
    {
        return $this->cartHelper->getCart();
    }
}
