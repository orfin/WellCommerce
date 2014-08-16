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

namespace WellCommerce\Bundle\ShopBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\Form\DataTransformerInterface;

/**
 * Class ShopToCollectionTransformer
 *
 * @package WellCommerce\Bundle\ShopBundle\Form\DataTransformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopToCollectionTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($collection)
    {
        $items = [];
        foreach ($collection as $item) {
            $items[] = $item->getId();
        }

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($ids)
    {
        $collection = new ArrayCollection();
        if (null == $ids) {
            return $collection;
        }
        foreach ($ids as $id) {
            $shop = $this->manager->getRepository('WellCommerceShopBundle:Shop')->find($id);
            $collection->add($shop);
        }

        return $collection;
    }
} 