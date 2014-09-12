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
namespace WellCommerce\Bundle\NewsBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\AdminMenuBundle\Builder\AdminMenuItem;
use WellCommerce\Bundle\AdminMenuBundle\Event\AdminMenuInitEvent;
use WellCommerce\Bundle\CoreBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class MediaSubscriber
 *
 * @package WellCommerce\Bundle\MediaBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsSubscriber extends AbstractEventSubscriber
{
    /**
     * Adds new admin menu items to collection
     *
     * @param AdminMenuEvent $event
     */
    /*public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'media',
            'name'       => $this->translator->trans('menu.cms.media'),
            'link'       => $this->router->generate('admin.media.index'),
            'path'       => '[menu][cms][media]',
            'sort_order' => 10
        ]));
    }

    /**
     * {@inheritdoc}
     */
   /* public static function getSubscribedEvents()
    {
        return [
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }*/
}