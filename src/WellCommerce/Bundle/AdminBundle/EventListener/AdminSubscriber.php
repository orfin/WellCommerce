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
namespace WellCommerce\Bundle\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\AdminBundle\Entity\UserInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;

/**
 * Class AdminSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 0],
            'user.pre_create'        => ['onUserPreCreate', 0],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $user     = $this->getUser();
        $hasRoute = $this->getRequestHelper()->getAttributesBagParam('_route');
        if ($user instanceof UserInterface && $hasRoute) {
            $route = $this->getRouterHelper()->getCurrentRoute();
            if ($route->hasOption('require_admin_permission')) {
                $name       = $route->getOption('require_admin_permission');
                $permission = $this->getSecurityHelper()->getPermission($name, $user);
                if (empty($permission)) {
                    $event->setController([$this->get('user.controller.admin'), 'accessDeniedAction']);
                }
            }
        }
    }

    public function onUserPreCreate(ResourceEvent $resourceEvent)
    {
        $password = $this->getSecurityHelper()->generateRandomPassword();
        $role     = $this->get('role.repository')->findOneByName('admin');
        $user     = $resourceEvent->getResource();
        if ($user instanceof UserInterface) {
            $user->addRole($role);
            $user->setPassword($password);

            $email      = $user->getEmail();
            $title      = $this->getTranslatorHelper()->trans('user.email.title.register');
            $template   = 'WellCommerceAdminBundle:Admin/Email:register.html.twig';
            $parameters = ['user' => $user, 'password' => $password];
            $shop       = $this->get('shop.context.admin')->getCurrentShop();

            $this->getMailerHelper()->sendEmail($email, $title, $template, $parameters, $shop->getMailerConfiguration());
        }
    }
}
