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
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\LayoutBundle\Repository\LayoutThemeRepositoryInterface;
use WellCommerce\Bundle\LayoutBundle\Theme\ShopTheme;

/**
 * Class LayoutSubscriber
 *
 * @package WellCommerce\Bundle\LayoutBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutSubscriber extends AbstractEventSubscriber
{
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

    /**
     * Constructor
     *
     * @param ShopTheme                      $shopTheme
     * @param Reader                         $reader
     * @param LayoutThemeRepositoryInterface $layoutThemeRepository
     */
    public function __construct(
        ShopTheme $shopTheme,
        Reader $reader,
        LayoutThemeRepositoryInterface $layoutThemeRepository
    ) {
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
        $loader = new XmlLoader($event->getBuilder(), new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('admin_menu.xml');
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
            AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent',
            KernelEvents::CONTROLLER   => ['onKernelController', -256],
        ];
    }
}