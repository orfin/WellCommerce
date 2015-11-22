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

namespace WellCommerce\AppBundle\Form\Admin\DataTransformer;

use Doctrine\ORM\PersistentCollection;
use WellCommerce\AppBundle\Form\DataTransformer\CollectionToArrayTransformer;

/**
 * Class CollectionToArrayTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaCollectionToArrayTransformer extends CollectionToArrayTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($modelData)
    {
        if (null === $modelData || !$modelData instanceof PersistentCollection) {
            return [];
        }

        $items = [];
        foreach ($modelData as $item) {
            if ($item->getMainPhoto() == 1) {
                $items['main_photo'] = $item->getPhoto()->getId();
            }
            $items['photos'][] = $item->getPhoto()->getId();
        }

        return $items;
    }
}
