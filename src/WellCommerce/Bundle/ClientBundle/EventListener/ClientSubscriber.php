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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Event\EntityEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Mailer\MailerHelperInterface;
use WellCommerce\Bundle\CoreBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;

/**
 * Class ClientSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientSubscriber implements EventSubscriberInterface
{
    /**
     * @var ManagerInterface
     */
    private $clientManager;
    
    /**
     * @var MailerHelperInterface
     */
    private $mailerHelper;
    
    /**
     * ClientSubscriber constructor.
     *
     * @param ManagerInterface      $clientManager
     * @param MailerHelperInterface $mailerHelper
     */
    public function __construct (ManagerInterface $clientManager, MailerHelperInterface $mailerHelper)
    {
        $this->clientManager = $clientManager;
        $this->mailerHelper  = $mailerHelper;
    }
    
    public static function getSubscribedEvents ()
    {
        return [
            'client.post_create' => ['onClientPostCreate'],
            'client.pre_create'  => ['onClientPreCreate'],
            'order.post_update'  => ['onOrderChangedEvent', 0],
        ];
    }
    
    public function onClientPreCreate (EntityEvent $event)
    {
        $client = $event->getEntity();
        if ($client instanceof ClientInterface) {
            $userName = $client->getUsername();
            $client->getContactDetails()->setEmail($userName);
            if (null === $client->getClientGroup()) {
                $client->setClientGroup($client->getShop()->getClientGroup());
            }
        }
    }
    
    public function onOrderChangedEvent (EntityEvent $event)
    {
        $order = $event->getEntity();
        if ($order instanceof OrderInterface) {
            $client = $order->getClient();
            if (null !== $order->getClient()) {
                $client->setContactDetails($order->getContactDetails());
                $client->setBillingAddress($order->getBillingAddress());
                $client->setShippingAddress($order->getShippingAddress());
                $this->clientManager->updateResource($client);
            }
        }
    }
    
    public function onClientPostCreate (EntityEvent $event)
    {

//        $client = $event->getEntity();
//        if ($client instanceof ClientInterface) {
//            $this->getMailerHelper()->sendEmail([
//                'recipient'     => $client->getContactDetails()->getEmail(),
//                'subject'       => $this->getTranslatorHelper()->trans('client.email.heading.register'),
//                'template'      => 'WellCommerceAppBundle:Email:register.html.twig',
//                'parameters'    => [
//                    'client' => $client,
//                ],
//                'configuration' => $client->getShop()->getMailerConfiguration(),
//            ]);
//        }
    }
}
