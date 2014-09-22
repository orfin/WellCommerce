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

    public function onKernelRequest(GetResponseEvent $event)
    {
        $host  = $event->getRequest()->server->get('SERVER_NAME');
        $theme = $this->layoutThemeRepository->find(6);
        $this->shopTheme->setCurrentTheme($theme);
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $host  = $event->getRequest()->server->get('SERVER_NAME');
        $theme = $this->layoutThemeRepository->find(6);
        $this->shopTheme->setCurrentTheme($theme);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent',
            KernelEvents::CONTROLLER   => ['onKernelController', -250],
            KernelEvents::REQUEST      => ['onKernelRequest', -250],
        ];
    }
}