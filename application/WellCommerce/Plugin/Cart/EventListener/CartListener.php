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
namespace WellCommerce\Plugin\Cart\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CartListener
 *
 * @package WellCommerce\Plugin\Cart\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return [];
    }
}