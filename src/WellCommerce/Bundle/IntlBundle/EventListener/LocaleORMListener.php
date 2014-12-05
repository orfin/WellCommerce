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

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * Class LocaleORMListener
 *
 * @package WellCommerce\Bundle\IntlBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleORMListener implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        if (null === $classMetadata->reflClass) {
            return;
        }

        if ($classMetadata->hasField('locale')) {

//            // remove old field mapping
//            unset($classMetadata->fieldMappings['locale']);
//            unset($classMetadata->fieldNames['locale']);
//            unset($classMetadata->columnNames['locale']);
//
//            $classMetadata->mapManyToOne([
//                'fieldName'    => 'locale',
//                'nullable'     => false,
//                'joinColumns'  => [
//                    [
//                        'name'                 => 'locale',
//                        'referencedColumnName' => 'code',
//                        'onDelete'             => 'CASCADE'
//                    ]
//                ],
//                'targetEntity' => 'WellCommerce\\Bundle\\IntlBundle\\Entity\\Locale'
//            ]);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {

    }

    public function getSubscribedEvents()
    {
        return [
            'postRemove',
        ];
    }

} 