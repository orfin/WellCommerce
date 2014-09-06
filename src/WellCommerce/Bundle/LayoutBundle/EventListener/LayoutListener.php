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
namespace WellCommerce\Bundle\LayoutBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\AdminMenuBundle\Builder\AdminMenuItem;
use WellCommerce\Bundle\AdminMenuBundle\Event\AdminMenuInitEvent;
use WellCommerce\Bundle\CoreBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\LayoutBundle\Repository\LayoutThemeRepositoryInterface;
use WellCommerce\Bundle\LayoutBundle\Theme\ShopTheme;

/**
 * Class LayoutListener
 *
 * @package WellCommerce\Bundle\LayoutBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ShopTheme
     */
    private $shopTheme;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var LayoutThemeRepositoryInterface
     */
    private $layoutThemeRepository;

    public function __construct(
        ContainerInterface $container,
        TranslatorInterface $translator,
        RouterInterface $router,
        ShopTheme $shopTheme,
        Reader $reader,
        LayoutThemeRepositoryInterface $layoutThemeRepository
    ) {
        $this->container             = $container;
        $this->translator            = $translator;
        $this->router                = $router;
        $this->shopTheme             = $shopTheme;
        $this->reader                = $reader;
        $this->layoutThemeRepository = $layoutThemeRepository;
    }

    /**
     * Adds new admin menu items to collection
     *
     * @param AdminMenuEvent $event
     */
    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'layout_theme',
            'name'       => $this->translator->trans('menu.layout.layout_theme'),
            'link'       => $this->router->generate('admin.layout_theme.index'),
            'path'       => '[menu][layout][layout_theme]',
            'sort_order' => 10
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'layout_page',
            'name'       => $this->translator->trans('menu.layout.layout_page'),
            'link'       => $this->router->generate('admin.layout_page.index'),
            'path'       => '[menu][layout][layout_page]',
            'sort_order' => 20
        ]));

        $builder->add(new AdminMenuItem([
            'id'         => 'layout_box',
            'name'       => $this->translator->trans('menu.layout.layout_box'),
            'link'       => $this->router->generate('admin.layout_box.index'),
            'path'       => '[menu][layout][layout_box]',
            'sort_order' => 30
        ]));
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        list($controller,) = $event->getController();

        $host     = $event->getRequest()->server->get('SERVER_NAME');
        $refClass = new \ReflectionClass($controller);
        $layout   = $this->reader->getClassAnnotation($refClass, 'WellCommerce\\Bundle\\LayoutBundle\\Manager\\Layout');
        if (null !== $layout) {
            $theme = $this->layoutThemeRepository->find(1);
            if (null != $theme) {
                $columns = $this->layoutThemeRepository->getLayoutColumns($theme, $layout);
                $layout->setColumns($columns);
                $this->shopTheme->setCurrentTheme($theme->getFolder());
                $controller->setLayout($layout);
            }

        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent',
            KernelEvents::CONTROLLER                  => ['onKernelController', -256],
        ];
    }
}