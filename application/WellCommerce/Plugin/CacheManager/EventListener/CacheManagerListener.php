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
namespace WellCommerce\Plugin\CacheManager\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Core\Event\RepositoryEvent;
use WellCommerce\Plugin\Layout\Repository\LayoutBoxRepositoryInterface;
use WellCommerce\Plugin\Layout\Repository\LayoutPageRepositoryInterface;

/**
 * Class CacheManagerListener
 *
 * @package WellCommerce\Plugin\CacheManager\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CacheManagerListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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