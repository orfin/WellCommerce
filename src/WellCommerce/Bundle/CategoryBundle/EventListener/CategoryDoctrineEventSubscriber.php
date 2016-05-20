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

namespace WellCommerce\Bundle\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Query\Expr;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;

/**
 * Class CategoryDoctrineEventSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDoctrineEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'onFlush'
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
//        $em  = $args->getEntityManager();
//        $uow = $em->getUnitOfWork();
//
//        $scheduledEntityChanges = [
//            'insert' => $uow->getScheduledEntityInsertions(),
//            'update' => $uow->getScheduledEntityUpdates(),
//            'delete' => $uow->getScheduledEntityDeletions()
//        ];
//
//        foreach ($scheduledEntityChanges as $change => $entities) {
//            foreach ($entities as $entity) {
//                if ($entity instanceof CategoryInterface) {
//                    $this->recalculateCategoryTotals($entity, $em);
//                }
//            }
//        }
    }

    private function recalculateCategoryTotals(CategoryInterface $category, EntityManager $em)
    {
//        $category->setProductsCount($category->getProducts()->count());
//        $category->setChildrenCount($category->getChildren()->count());
//        $metadata = $em->getClassMetadata(Category::class);
//        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($metadata, $category);
    }
}
