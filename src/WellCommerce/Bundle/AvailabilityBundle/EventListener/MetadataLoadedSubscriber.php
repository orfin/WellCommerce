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

namespace WellCommerce\Bundle\AvailabilityBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Filesystem\Filesystem;
use WellCommerce\Bundle\AvailabilityBundle\Entity\Availability;
use WellCommerce\Bundle\DistributionBundle\Collection\BundlePluginCollection;
use Zend\Code\Generator\PropertyGenerator;
use Zend\Code\Generator\TraitGenerator;
use Zend\Code\Reflection\ClassReflection;

class MetadataLoadedSubscriber implements EventSubscriber
{
    protected $collection;

    public function __construct(BundlePluginCollection $collection)
    {
        $this->collection = $collection;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var $classMetadata \Doctrine\Common\Persistence\Mapping\ClassMetadata */
        $classMetadata   = $eventArgs->getClassMetadata();
        $class           = $classMetadata->getName();
        $reflectionClass = $classMetadata->getReflectionClass();

        if ($this->supports($class)) {

            $field = 'fooBar';

            if (!$classMetadata->hasField($field)) {

                if (false === $this->reflectionHelper->hasProperty($reflectionClass, $field)) {
                    $entityExtraTrait = $this->reflectionHelper->getEntityExtraTrait($reflectionClass);
                    $generator        = $this->addPropertyToClass($reflectionClass, $field);
                    $filesystem       = new Filesystem();
                    $filesystem->dumpFile($entityExtraTrait->getFileName(), '<?php' . PHP_EOL . $generator->generate());
                }

                $classMetadata->mapField([
                    'fieldName' => $field,
                    'nullable'  => true
                ]);
            }
        }


//        if (!isset($this->dynamicMapping[$class])) {
//            return;
//        }
//        foreach ((array)$this->dynamicMapping[$class] as $name => $fieldMapping) {
//            $fieldMapping['fieldName'] = $name;
//            $classMetadata->mapManyToOne($fieldMapping);
//        }
    }

    /**
     * @param \ReflectionClass $class
     * @param                  $property
     *
     * @return TraitGenerator
     */
    protected function addPropertyToClass(\ReflectionClass $class, $property)
    {
        $entityExtraTraitName = $this->reflectionHelper->getEntityExtraTraitName($class);

        $generator = TraitGenerator::fromReflection(
            new ClassReflection($entityExtraTraitName)
        );

        $generator->addProperty($property, null, PropertyGenerator::FLAG_PROTECTED);

        return $generator;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata
        ];
    }

    protected function supports($class)
    {
        return $class === Availability::class;
    }
}
