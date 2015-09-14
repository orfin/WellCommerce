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

namespace WellCommerce\Bundle\CartBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CartBundle\Entity\CartTotals;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;
use WellCommerce\Bundle\PaymentBundle\Repository\PaymentMethodRepositoryInterface;
use WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepositoryInterface;

/**
 * Class CartFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartFactory extends AbstractFactory implements CartFactoryInterface
{
    /**
     * @var PaymentMethodRepositoryInterface
     */
    protected $paymentMethodRepository;

    /**
     * @var ShippingMethodRepositoryInterface
     */
    protected $shippingMethodRepository;

    /**
     * Constructor
     *
     * @param PaymentMethodRepositoryInterface  $paymentMethodRepository
     * @param ShippingMethodRepositoryInterface $shippingMethodRepository
     */
    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository, ShippingMethodRepositoryInterface $shippingMethodRepository)
    {
        $this->paymentMethodRepository  = $paymentMethodRepository;
        $this->shippingMethodRepository = $shippingMethodRepository;
    }

    /**
     * @return \WellCommerce\Bundle\CartBundle\Entity\CartInterface
     */
    public function create()
    {
        $cart = new Cart();
        $cart->setProducts(new ArrayCollection());
        $cart->setTotals(new CartTotals());
        $cart->setPaymentMethod($this->paymentMethodRepository->getDefaultPaymentMethod());
        $cart->setShippingMethod($this->shippingMethodRepository->getDefaultShippingMethod());

        return $cart;
    }

    public function createCartForClient(ClientInterface $client, ShopInterface $shop)
    {

    }
}
