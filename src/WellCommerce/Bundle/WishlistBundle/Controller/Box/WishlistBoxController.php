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

namespace WellCommerce\Bundle\AppBundle\Controller\Box;

use WellCommerce\Bundle\AppBundle\Entity\WishlistInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Component\DataSet\Conditions\Condition\In;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class WishlistBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WishlistBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $dataset = $this->get('product.dataset.front')->getResult('array', [
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => $this->getConditions()
        ]);

        return $this->displayTemplate('index', [
            'dataset' => $dataset
        ]);
    }

    /**
     * @return ConditionsCollection
     */
    protected function getConditions()
    {
        $wishlist   = $this->manager->getClient()->getWishlist();
        $productIds = [];

        $wishlist->map(function (WishlistInterface $Wishlist) use (&$productIds) {
            $productIds[] = $Wishlist->getProduct()->getId();
        });

        $conditions = new ConditionsCollection();
        $conditions->add(new In('id', $productIds));

        return $conditions;
    }
}
