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
namespace WellCommerce\Bundle\ClientBundle\EventListener;

use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\ResourceEvent;

/**
 * Class ClientSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            'client.post_create' => ['onClientPostCreate'],
            'client.pre_create'  => ['onClientPreCreate']
        ];
    }

    public function onClientPreCreate(ResourceEvent $event)
    {
        $client      = $event->getResource();
        $shopContext = $this->get('shop.context.front');
        if ($client instanceof ClientInterface) {
            $userName = $client->getUsername();
            $client->getContactDetails()->setEmail($userName);
            $client->setShop($shopContext->getCurrentShop());
        }
    }

    public function onClientPostCreate(ResourceEvent $event)
    {
        $client = $event->getResource();
        if ($client instanceof ClientInterface) {
            $email      = $client->getContactDetails()->getEmail();
            $title      = $this->getTranslatorHelper()->trans('client.email.heading.register');
            $template   = 'WellCommerceAppBundle:Email:register.html.twig';
            $parameters = ['client' => $client];
            $shop       = $client->getShop();

            $this->getMailerHelper()->sendEmail($email, $title, $template, $parameters, $shop->getMailerConfiguration());
        }
    }
}
