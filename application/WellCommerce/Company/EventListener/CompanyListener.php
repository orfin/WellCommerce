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
namespace WellCommerce\Company\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class CompanyListener
 *
 * @package WellCommerce\Company\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyListener implements EventSubscriberInterface
{
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
            'id'         => 'company',
            'name'       => $this->container->get('translation')->trans('Companies'),
            'link'       => $this->container->get('router')->generate('admin.company.index'),
            'path'       => '[menu][configuration][company]',
            'sort_order' => 20
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