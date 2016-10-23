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
namespace WellCommerce\Bundle\OrderBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WellCommerce\Bundle\CoreBundle\Event\EntityEvent;
use WellCommerce\Bundle\CoreBundle\Helper\Mailer\MailerHelper;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusHistoryInterface;

/**
 * Class OrderStatusHistorySubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class OrderStatusHistorySubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerHelper
     */
    private $mailerHelper;
    
    /**
     * OrderStatusHistorySubscriber constructor.
     *
     * @param MailerHelper $mailerHelper
     */
    public function __construct(MailerHelper $mailerHelper)
    {
        $this->mailerHelper = $mailerHelper;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            'order_status_history.post_create' => ['onOrderStatusHistoryCreated', 0],
        ];
    }
    
    public function onOrderStatusHistoryCreated(EntityEvent $event)
    {
        $history = $event->getEntity();
        if ($history instanceof OrderStatusHistoryInterface) {
            $order = $history->getOrder();
            if ($history->isNotify()) {
                $this->mailerHelper->sendEmail([
                    'recipient'     => $order->getContactDetails()->getEmail(),
                    'bcc'           => [],
                    'subject'       => sprintf('Zmiana statusu zamówienia %s', $order->getNumber()),
                    'template'      => 'WellCommerceAppBundle:Email:order_status.html.twig',
                    'parameters'    => [
                        'history' => $history,
                        'order'   => $order,
                    ],
                    'configuration' => $order->getShop()->getMailerConfiguration(),
                ]);
            }
        }
    }
}
