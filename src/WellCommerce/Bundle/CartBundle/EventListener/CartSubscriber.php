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
use WellCommerce\Bundle\CartBundle\Manager\Front\CartManagerInterface;
use WellCommerce\Bundle\CartBundle\Visitor\CartVisitorTraverserInterface;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
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
            KernelEvents::CONTROLLER => ['onKernelController', 0],
            'cart.form_init'         => ['onFormInit', 0],
            'cart.pre_create'        => ['onCartChangedEvent', 0],
            'cart.pre_update'        => ['onCartChangedEvent', 0],
            'cart.post_init'         => ['onCartInitEvent', 0],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $this->cartManager->initializeCart();
    }

    public function onCartInitEvent(ResourceEvent $event)
    {
        $this->cartVisitorTraverser->traverse($event->getResource());
    }

    public function onCartChangedEvent(ResourceEvent $event)
    {
        $this->cartVisitorTraverser->traverse($event->getResource());
    }

    public function onFormInit(FormEvent $event)
    {
        $form                 = $event->getForm();
        $cart                 = $this->cartManager->getCurrentCart();
        $currencyHelper       = $this->getCurrencyHelper();
        $shippingMethodSelect = $form->getChildren()->get('shippingMethodCost');
        $collection           = $this->cartShippingMethodProvider->getShippingMethodCostsCollection($cart);

        foreach ($collection->all() as $cost) {
            $shippingMethod = $cost->getShippingMethod();
            $baseCurrency   = $shippingMethod->getCurrency()->getCode();
            $grossAmount    = $cost->getCost()->getGrossAmount();

            $label = [
                'name'    => $shippingMethod->translate()->getName(),
                'comment' => $currencyHelper->convertAndFormat($grossAmount, $baseCurrency)
            ];

            $shippingMethodSelect->addOptionToSelect($cost->getId(), $label);
        }
    }
}
