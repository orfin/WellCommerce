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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\ClientBundle\Factory\ClientBillingAddressFactory;
use WellCommerce\Bundle\ClientBundle\Factory\ClientContactDetailsFactory;
use WellCommerce\Bundle\ClientBundle\Factory\ClientDetailsFactory;
use WellCommerce\Bundle\ClientBundle\Factory\ClientShippingAddressFactory;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\CoreBundle\Helper\Request\RequestHelperInterface;
use WellCommerce\Bundle\CoreBundle\Helper\Security\SecurityHelperInterface;
use WellCommerce\Bundle\OrderBundle\Entity\Order;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderProductTotal;
use WellCommerce\Bundle\OrderBundle\Entity\OrderSummary;
use WellCommerce\Bundle\ShopBundle\Storage\ShopStorage;

/**
 * Class OrderFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderFactory extends AbstractEntityFactory
{
    /**
     * @var ClientContactDetailsFactory
     */
    private $contactDetailsFactory;
    
    /**
     * @var ClientDetailsFactory
     */
    private $detailsFactory;
    
    /**
     * @var ClientBillingAddressFactory
     */
    private $billingAddressFactory;
    
    /**
     * @var ClientShippingAddressFactory
     */
    private $shippingAddressFactory;
    
    /**
     * @var ShopStorage
     */
    private $shopStorage;
    
    /**
     * @var RequestHelperInterface
     */
    private $requestHelper;
    
    /**
     * @var SecurityHelperInterface
     */
    private $securityHelper;
    
    /**
     * OrderFactory constructor.
     *
     * @param ClientContactDetailsFactory  $contactDetailsFactory
     * @param ClientDetailsFactory         $detailsFactory
     * @param ClientBillingAddressFactory  $billingAddressFactory
     * @param ClientShippingAddressFactory $shippingAddressFactory
     * @param ShopStorage                  $shopStorage
     * @param RequestHelperInterface       $requestHelper
     * @param SecurityHelperInterface      $securityHelper
     */
    public function __construct(
        ClientContactDetailsFactory $contactDetailsFactory,
        ClientDetailsFactory $detailsFactory,
        ClientBillingAddressFactory $billingAddressFactory,
        ClientShippingAddressFactory $shippingAddressFactory,
        ShopStorage $shopStorage,
        RequestHelperInterface $requestHelper,
        SecurityHelperInterface $securityHelper
    ) {
        $this->contactDetailsFactory  = $contactDetailsFactory;
        $this->detailsFactory         = $detailsFactory;
        $this->billingAddressFactory  = $billingAddressFactory;
        $this->shippingAddressFactory = $shippingAddressFactory;
        $this->shopStorage            = $shopStorage;
        $this->requestHelper          = $requestHelper;
        $this->securityHelper         = $securityHelper;
    }
    
    public function create() : OrderInterface
    {
        $order = new Order();
        $order->setConfirmed(false);
        $order->setProducts($this->createEmptyCollection());
        $order->setProductTotal(new OrderProductTotal());
        $order->setModifiers($this->createEmptyCollection());
        $order->setPayments($this->createEmptyCollection());
        $order->setOrderStatusHistory($this->createEmptyCollection());
        $order->setComment('');
        $order->setCurrency($this->requestHelper->getCurrentCurrency());
        $order->setSummary(new OrderSummary());
        $order->setShop($this->shopStorage->getCurrentShop());
        $order->setClient($this->securityHelper->getCurrentClient());
        $order->setSessionId($this->requestHelper->getSessionId());

        $client = $this->securityHelper->getCurrentClient();

        if ($client instanceof ClientInterface) {
            $order->setClientDetails($client->getClientDetails());
            $order->setContactDetails($client->getContactDetails());
            $order->setBillingAddress($client->getBillingAddress());
            $order->setShippingAddress($client->getShippingAddress());
        } else {
            $order->setClientDetails($this->detailsFactory->create());
            $order->setContactDetails($this->contactDetailsFactory->create());
            $order->setBillingAddress($this->billingAddressFactory->create());
            $order->setShippingAddress($this->shippingAddressFactory->create());
        }


        return $order;
    }
}
