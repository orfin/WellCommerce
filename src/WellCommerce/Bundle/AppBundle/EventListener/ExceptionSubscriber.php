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
namespace WellCommerce\Bundle\AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ExceptionSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ExceptionSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 0],
        ];
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->getKernel()->getEnvironment() !== 'dev') {
            $exception = $event->getException();
            $event->getRequest()->setLocale($this->container->getParameter('locale'));
            if ($exception instanceof HttpExceptionInterface) {
                $content = $this->getTemplatingHelper()->render('WellCommerceAppBundle:Front/Exception:404.html.twig', [
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getCode(),
                ]);
            } else {
                $content = $this->getTemplatingHelper()->render('WellCommerceAppBundle:Front/Exception:500.html.twig', [
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getCode(),
                ]);
            }
            
            $response = new Response();
            $response->setContent($content);
            
            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                $response->headers->replace($exception->getHeaders());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            
            $event->setResponse($response);
        }
    }
}
