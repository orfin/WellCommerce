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
namespace WellCommerce\Bundle\SearchBundle\EventListener;

use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\DoctrineBundle\Event\EntityEvent;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\SearchBundle\Context\ProductContext;

/**
 * Class ClientSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SearchIndexerSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            'product.post_create'  => ['onProductCreated'],
            'product.post_update'  => ['onProductChanged'],
            'category.post_create' => ['onCategoryPreCreate']
        ];
    }

    public function onProductCreated(EntityEvent $event)
    {
        $product = $event->getEntity();
        if ($product instanceof ProductInterface) {
            $document = new ProductContext($product);
            $this->getSearchEngine()->addDocument($document);
        }
    }

    public function onProductUpdated(EntityEvent $event)
    {
        $product = $event->getEntity();
        if ($product instanceof ProductInterface) {
            $document = new ProductContext($product);
            $this->getSearchEngine()->addDocument($document);
        }
    }
}
