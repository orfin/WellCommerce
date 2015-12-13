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
namespace WellCommerce\Bundle\ShopBundle\Twig\Extension;

use WellCommerce\Bundle\ShopBundle\Context\ShopContextInterface;

/**
 * Class ShopExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopExtension extends \Twig_Extension
{
    /**
     * @var ShopContextInterface
     */
    protected $shopContext;

    /**
     * Constructor
     *
     * @param ShopContextInterface $shopContext
     */
    public function __construct(ShopContextInterface $shopContext)
    {
        $this->shopContext = $shopContext;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('currentShop', [$this, 'getCurrentShop'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'shop';
    }

    public function getCurrentShop()
    {
        return $this->shopContext->getCurrentShop();
    }
}
