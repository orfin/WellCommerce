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

namespace WellCommerce\Bundle\PluginBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use WellCommerce\Bundle\PluginBundle\Visitor\ClassMetadata\ClassMetadataVisitorTraverserInterface;

/**
 * Class ClassMetadataEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClassMetadataEventSubscriber implements EventSubscriber
{
    /**
     * @var ClassMetadataVisitorTraverserInterface
     */
    protected $traverser;

    /**
     * ProductDoctrineEventSubscriber constructor.
     *
     * @param ClassMetadataVisitorTraverserInterface $traverser
     */
    public function __construct(ClassMetadataVisitorTraverserInterface $traverser)
    {
        $this->traverser = $traverser;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var $metadata \Doctrine\Common\Persistence\Mapping\ClassMetadata */
        $metadata  = $eventArgs->getClassMetadata();

        $this->traverser->traverse($metadata);
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata
        ];
    }
}
