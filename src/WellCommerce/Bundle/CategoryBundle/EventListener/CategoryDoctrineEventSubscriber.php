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
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Query\Expr;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

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
            'prePersist',
            'preUpdate',
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->onCategoryDataBeforeSave($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->onCategoryDataBeforeSave($args);
    }

    public function onCategoryDataBeforeSave(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof CategoryInterface) {
            $entity->setProductsCount($entity->getProducts()->count());
            $entity->setChildrenCount($entity->getChildren()->count());
        }
    }
}
