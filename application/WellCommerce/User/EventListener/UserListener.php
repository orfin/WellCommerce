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
namespace WellCommerce\User\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class UserListener
 *
 * @package WellCommerce\Category\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserListener implements EventSubscriberInterface
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

    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'user',
            'name'       => $this->translator->trans('Users'),
            'link'       => $this->router->generate('admin.user.index'),
            'path'       => '[menu][configuration][user_management][user]',
            'sort_order' => 10
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'user_group',
            'name'       => $this->translator->trans('User groups'),
            'link'       => $this->router->generate('admin.user.index'),
            'path'       => '[menu][configuration][user_management][user_group]',
            'sort_order' => 20
        ]));
    }

    public static function getSubscribedEvents()
    {
        return [
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }
}