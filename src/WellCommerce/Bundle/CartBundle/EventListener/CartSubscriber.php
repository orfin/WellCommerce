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
use WellCommerce\Bundle\CoreBundle\Event\DataSetEvent;
use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Component\DataSet\Column\Column;

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
     * Constructor
     *
     * @param CartManagerInterface          $cartManager
     * @param CartVisitorTraverserInterface $cartVisitorTraverser
     */
    public function __construct(CartManagerInterface $cartManager, CartVisitorTraverserInterface $cartVisitorTraverser)
    {
        $this->cartManager          = $cartManager;
        $this->cartVisitorTraverser = $cartVisitorTraverser;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER    => ['onKernelController', -150],
            'cart.pre_create'           => ['onCartChangedEvent', 0],
            'cart.pre_update'           => ['onCartChangedEvent', 0],
            'cart.post_init'            => ['onCartInitEvent', 0],
            'cart_product.dataset_init' => ['onDataSetInitEvent', 0]
        ];
    }

    public function onDataSetInitEvent(DataSetEvent $event)
    {
        $columns = $event->getDataSet()->getColumns();
        $columns->add(new Column([
            'source' => 'cart_product.quantity',
            'alias'  => 'qty'
        ]));
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
}
