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
namespace WellCommerce\AppBundle\EventListener;

use WellCommerce\AppBundle\Entity\ClientInterface;
use WellCommerce\CoreBundle\Event\ResourceEvent;
use WellCommerce\CoreBundle\EventListener\AbstractEventSubscriber;

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
            'client.post_create' => ['onClientPostCreate']
        ];
    }

    public function onClientPostCreate(ResourceEvent $event)
    {
        $client = $event->getResource();
        if ($client instanceof ClientInterface) {
            $email = $client->getContactDetails()->getEmail();
            $title = $this->getTranslatorHelper()->trans('client.email.heading.register');
            $body  = $this->getEmailBody($client);
            $shop  = $client->getShop();

            $this->getMailerHelper()->sendEmail($email, $title, $body, $shop->getMailerConfiguration());
        }
    }

    protected function getEmailBody(ClientInterface $client)
    {
        return $this->getTemplatingelper()->render(
            'WellCommerceAppBundle:Email:register.html.twig', [
            'client' => $client
        ]);
    }
}
