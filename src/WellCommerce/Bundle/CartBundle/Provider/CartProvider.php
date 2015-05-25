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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CartBundle\Repository\CartProductRepositoryInterface;
use WellCommerce\Bundle\CartBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;

/**
 * Class CartProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProvider extends AbstractProvider
{

    protected $requestHelper;

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var CartProductRepositoryInterface
     */
    protected $cartProductRepository;

    public function setRequestHelper(RequestHelperInterface $requestHelper)
    {

    }

    /**
     * @param CartRepositoryInterface $cartRepository
     */
    public function setCartRepository(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param CartProductRepositoryInterface $cartProductRepository
     */
    public function setCartProductRepository(CartProductRepositoryInterface $cartProductRepository)
    {
        $this->cartProductRepository = $cartProductRepository;
    }
}