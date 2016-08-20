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

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

/**
 * Class TimestampableSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TimestampableSubscriber implements EventSubscriber
{
    /**
     * @var array Timestampable fields
     */
    protected $fields = ['createdAt', 'updatedAt'];

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadataInfo
     */
    protected $classMetadata;

    /**
     * Returns subscribed events
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::loadClassMetadata];
    }

    /**
     * Event triggered during metadata loading
     *
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $this->classMetadata = $eventArgs->getClassMetadata();
        $reflectionClass     = $this->classMetadata->getReflectionClass();

        if (null === $reflectionClass) {
            return;
        }

        if ($this->hasMethod($reflectionClass, 'updateTimestamps')) {
            $this->addLifecycleCallbacks();
            $this->mapFields();
        }
    }

    /**
     * Adds timestampable lifecycle callbacks to entity
     */
    protected function addLifecycleCallbacks()
    {
        foreach ($this->getLifecycleCallbacks() as $callback) {
            $this->classMetadata->addLifecycleCallback('updateTimestamps', $callback);
        }
    }

    protected function getLifecycleCallbacks()
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    /**
     * Iterates through fields and adds mapping to them
     */
    protected function mapFields()
    {
        foreach ($this->fields as $field) {
            $this->mapField($field);
        }
    }

    /**
     * Adds mapping to single field
     *
     * @param string $field
     */
    protected function mapField($field)
    {
        if (!$this->classMetadata->hasField($field)) {
            $this->classMetadata->mapField([
                'fieldName' => $field,
                'type'      => 'datetime',
                'nullable'  => true,
            ]);
        }
    }

    /**
     * Checks whether the class contains such a method
     *
     * @param \ReflectionClass $class
     * @param string           $methodName
     *
     * @return bool
     */
    protected function hasMethod(\ReflectionClass $class, $methodName)
    {
        return $class->hasMethod($methodName);
    }
}
