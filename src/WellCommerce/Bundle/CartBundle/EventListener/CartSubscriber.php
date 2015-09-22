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
namespace WellCommerce\Bundle\CartBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CartBundle\Event\CartEvent;
use WellCommerce\Bundle\CartBundle\EventDispatcher\CartEventDispatcher;
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorTraverserInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\FormBundle\Event\FormEvent;
use WellCommerce\Bundle\ShippingBundle\Provider\CartShippingMethodProvider;

/**
 * Class CartSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartSubscriber extends AbstractEventSubscriber
{
    /**
     * @var CartManagerInterface
     */
    protected $cartManager;

    /**
     * @var CartVisitorTraverserInterface
     */
    protected $cartVisitorTraverser;

    /**
     * @var CartShippingMethodProvider
     */
    protected $cartShippingMethodProvider;

    /**
     * Constructor
     *
     * @param CartManagerInterface          $cartManager
     * @param CartVisitorTraverserInterface $cartVisitorTraverser
     */
    /**
     * Constructor
     *
     * @param CartManagerInterface          $cartManager
     * @param CartVisitorTraverserInterface $cartVisitorTraverser
     * @param CartShippingMethodProvider    $cartShippingMethodProvider
     */
    public function __construct(CartManagerInterface $cartManager, CartVisitorTraverserInterface $cartVisitorTraverser, CartShippingMethodProvider $cartShippingMethodProvider)
    {
        $this->cartManager                = $cartManager;
        $this->cartVisitorTraverser       = $cartVisitorTraverser;
        $this->cartShippingMethodProvider = $cartShippingMethodProvider;
    }

    public static function getSubscribedEvents()
    {
        return [
            CartEventDispatcher::POST_CART_CHANGE_EVENT => ['onCartChangedEvent', 0],
            KernelEvents::CONTROLLER                    => ['onKernelController', 0],
            'cart.form_init'                            => ['onFormInit', 0],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->cartManager->initializeCart();
    }

    public function onCartChangedEvent(CartEvent $event)
    {
        $this->cartVisitorTraverser->traverse($event->getCart());
    }

    public function onFormInit(FormEvent $event)
    {
        $form                  = $event->getForm();
        $cart                  = $this->cartManager->getCurrentCart();
        $formatter             = $this->getCurrencyFormatter();
        $shippingMethodSelect  = $form->getChildren()->get('shippingMethod');
        $shippingMethodOptions = $this->cartShippingMethodProvider->getShippingMethodOptions($cart);

        foreach ($shippingMethodOptions->all() as $option) {
            $shippingMethodSelect->addOptionToSelect($option->getId(), [
                    'name'    => $option->getName(),
                    'comment' => $formatter->format($option->getGrossPrice())
                ]
            );
        }
    }
}
