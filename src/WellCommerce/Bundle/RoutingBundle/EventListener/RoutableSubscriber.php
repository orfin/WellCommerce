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

namespace WellCommerce\Bundle\RoutingBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\Route;

/**
 * Class RoutableSubscriber
 *
 * @package WellCommerce\Bundle\RoutingBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutableSubscriber implements EventSubscriber
{
    protected $needsFlush = false;

    /**
     * Add Route for new entity
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $em     = $args->getEntityManager();
        $entity = $args->getEntity();

        if ($entity instanceof RoutableSubjectInterface) {
            $this->generateRoute($entity, $em);
        }
    }

    /**
     * Update slug for existing entity
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $em     = $args->getEntityManager();
        $entity = $args->getEntity();

        if ($entity instanceof RoutableSubjectInterface) {
            $this->generateRoute($entity, $em);
        }
    }

    protected function generateRoute(RoutableSubjectInterface $entity, EntityManager $em)
    {
        if($em->getFilters()->isEnabled('locale')){
            $em->getFilters()->disable('locale');
        }

        if (null !== $route = $entity->getRoute()) {
            $em->remove($route);
        }

        $route = new Route();
        $route->setPath($entity->getSlug());
        $route->setStrategy($entity->getRouteGeneratorStrategy());
        $route->setLocale($entity->getLocale());
        $route->setIdentifier($entity->getTranslatable()->getId());

        $entity->setRoute($route);
        $em->persist($route);
        $this->needsFlush = true;
    }

    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        if ($this->needsFlush) {
            $this->needsFlush = false;
            $eventArgs->getEntityManager()->flush();
        }
    }

    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::postFlush,
            Events::postPersist,
        ];
    }
} 