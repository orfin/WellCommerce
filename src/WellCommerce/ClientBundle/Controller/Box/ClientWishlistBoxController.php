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

namespace WellCommerce\ClientBundle\Controller\Box;

use WellCommerce\ClientBundle\Entity\ClientWishlistInterface;
use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Component\DataSet\Conditions\Condition\In;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class ClientWishlistBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistBoxController extends AbstractBoxController
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

        $wishlist->map(function (ClientWishlistInterface $clientWishlist) use (&$productIds) {
            $productIds[] = $clientWishlist->getProduct()->getId();
        });

        $conditions = new ConditionsCollection();
        $conditions->add(new In('id', $productIds));

        return $conditions;
    }
}
