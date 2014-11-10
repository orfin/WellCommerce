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
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

/**
 * Class RoutableSubscriber
 *
 * @package WellCommerce\Bundle\RoutingBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutableSubscriber implements EventSubscriber
{

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /**
         * @var \Doctrine\ORM\Mapping\ClassMetadataInfo $classMetadata
         */
        $classMetadata = $eventArgs->getClassMetadata();

        if (null === $classMetadata->getReflectionClass()) {
            return;
        }

        if ($classMetadata->getReflectionClass()->hasMethod('generateRoute')) {
            $classMetadata->addLifecycleCallback('generateRoute', Events::postPersist);
            $classMetadata->addLifecycleCallback('generateRoute', Events::postUpdate);
        }
    }

    public function getSubscribedEvents()
    {
        return [
//            Events::loadClassMetadata
        ];
    }
} 