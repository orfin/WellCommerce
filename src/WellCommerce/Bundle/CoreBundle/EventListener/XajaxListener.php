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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Helper\XajaxManager;

/**
 * Class XajaxListener
 *
 * @package WellCommerce\Bundle\CoreBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class XajaxListener implements EventSubscriberInterface
{
    /**
     * @var \WellCommerce\Bundle\CoreBundle\Helper\XajaxManager
     */
    private $manager;

    /**
     * Constructor
     *
     * @param XajaxManager $manager
     */
    public function __construct(XajaxManager $manager)
    {
        $this->manager = $manager;
    }

    public function onKernelView()
    {
        $this->manager->processRequest();
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 10],
        ];
    }
}