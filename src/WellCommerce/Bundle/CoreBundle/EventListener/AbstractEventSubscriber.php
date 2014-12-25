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

namespace WellCommerce\Bundle\CoreBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;

/**
 * Class AbstractEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEventSubscriber extends ContainerAware implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent',
        ];
    }

    /**
     * Returns translator service
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslator()
    {
        return $this->container->get('translator');
    }

    /**
     * Returns router service
     *
     * @return \Symfony\Component\Routing\RouterInterface
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * Returns Doctrine helper
     *
     * @return \WellCommerce\Bundle\CoreBundle\Helper\Doctrine\DoctrineHelper
     */
    protected function getDoctrineHelper()
    {
        return $this->container->get('doctrine_helper');
    }

    /**
     * Returns property accessor instance
     *
     * @return \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        return PropertyAccess::createPropertyAccessor();
    }

    /**
     * Loads admin menu structure for in all subscribers
     *
     * @param AdminMenuEvent $event
     */
    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $reflection = new \ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $loader     = new XmlLoader($event->getBuilder(), new FileLocator($directory . '/../Resources/config'));
        $loader->load('admin_menu.xml');
    }
}