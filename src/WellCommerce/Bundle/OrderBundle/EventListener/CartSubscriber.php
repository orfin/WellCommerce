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
namespace WellCommerce\Bundle\OrderBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;
use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\OrderBundle\Visitor\CartVisitorTraverser;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverser;
use WellCommerce\Component\Form\Event\FormEvent;

/**
 * Class CartSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CartSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -150],
            'cart.post_init'         => ['onCartChangedEvent', 0],
            'cart.pre_create'        => ['onCartChangedEvent', 0],
            'cart.pre_update'        => ['onCartChangedEvent', 0],
            'cart_address.form_init' => ['onCartAddressFormInitEvent', 0],
        ];
    }
    
    public function onKernelController()
    {
        $this->getCartManager()->initializeCart();
    }
    
    public function onCartChangedEvent(ResourceEvent $event)
    {
        $cart = $event->getResource();
        if ($cart instanceof CartInterface) {
            $this->getOrderVisitorTraverser()->traverse($event->getResource());
        }
    }
    
    public function onCartAddressFormInitEvent(FormEvent $event)
    {
        $client = $event->getDefaultData();
        $cart   = $this->getCartManager()->getCartContext()->getCurrentCart();
        if ($client instanceof ClientInterface) {
            $cart->setBillingAddress($client->getBillingAddress());
            $cart->setShippingAddress($client->getShippingAddress());
            $cart->setContactDetails($client->getContactDetails());
        }
    }
    
    private function getCartManager() : CartManagerInterface
    {
        return $this->container->get('cart.manager.front');
    }
    
    private function getOrderVisitorTraverser() : OrderVisitorTraverser
    {
        return $this->container->get('order.visitor.traverser');
    }
}
