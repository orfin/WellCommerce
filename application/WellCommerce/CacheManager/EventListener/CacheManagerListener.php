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
namespace WellCommerce\CacheManager\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Core\Event\RepositoryEvent;
use WellCommerce\Layout\Repository\LayoutBoxRepositoryInterface;
use WellCommerce\Layout\Repository\LayoutPageRepositoryInterface;

/**
 * Class CacheManagerListener
 *
 * @package WellCommerce\CacheManager\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CacheManagerListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(ContainerInterface $container, TranslatorInterface $translator, RouterInterface $router)
    {
        $this->container  = $container;
        $this->translator = $translator;
        $this->router     = $router;
    }

    /**
     * Clears layout cache if page or box was changed
     *
     * @param RepositoryEvent $event
     */
    public function onLayoutChangeEvent(RepositoryEvent $event)
    {
        $this->container->get('cache_manager')->clearByPrefix('layout_');
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            LayoutPageRepositoryInterface::POST_SAVE_EVENT => 'onLayoutChangeEvent',
            LayoutBoxRepositoryInterface::POST_SAVE_EVENT  => 'onLayoutChangeEvent',
        ];
    }
}