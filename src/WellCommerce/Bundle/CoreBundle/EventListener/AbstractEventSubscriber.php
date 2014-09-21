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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;

/**
 * Class AbstractEventSubscriber
 *
 * @package WellCommerce\Bundle\CoreBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AbstractEventSubscriber extends ContainerAware implements ContainerAwareInterface, EventSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Sets translator instance
     *
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Sets router instance
     *
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Returns subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [];
    }
}