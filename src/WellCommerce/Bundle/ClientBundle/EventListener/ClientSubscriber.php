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
namespace WellCommerce\Bundle\IntlBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class CurrencySubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencySubscriber extends AbstractEventSubscriber
{
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -100],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $user = $this->getSecurityHelper()->getUser();

    }

    protected function getCurrentClient()
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token && $token->getUser() instanceof ClientInterface) {
            return $token->getUser();
        }

        return null;
    }
}
