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
namespace WellCommerce\FileManager\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class FileManagerListener
 *
 * @package WellCommerce\FileManager\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileManagerListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'file',
            'name'       => $this->container->get('translation')->trans('Files'),
            'link'       => $this->container->get('router')->generate('admin.file_manager.index'),
            'path'       => '[menu][cms][file_manager]',
            'sort_order' => 10
        ]));
    }

    public static function getSubscribedEvents()
    {
        return array(
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        );
    }
}