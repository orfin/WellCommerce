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
namespace WellCommerce\Layout\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class LayoutListener
 *
 * @package WellCommerce\Layout\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutListener implements EventSubscriberInterface
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
            'id'         => 'theme',
            'name'       => $this->translator->trans('Themes'),
            'link'       => $this->router->generate('admin.layout_theme.index'),
            'path'       => '[menu][layout][theme]',
            'sort_order' => 10
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'page',
            'name'       => $this->translator->trans('Pages'),
            'link'       => $this->router->generate('admin.layout_page.index'),
            'path'       => '[menu][layout][page]',
            'sort_order' => 20
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'box',
            'name'       => $this->translator->trans('Boxes'),
            'link'       => $this->router->generate('admin.layout_box.index'),
            'path'       => '[menu][layout][box]',
            'sort_order' => 30
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }
}