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

namespace WellCommerce\Bundle\ClientBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\ClientBundle\Entity\ClientWishlistInterface;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Component\DataSet\Conditions\Condition\In;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class WishlistBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientWishlistBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
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

    protected function getConditions() : ConditionsCollection
    {
        $wishlist   = $this->getAuthenticatedClient()->getWishlist();
        $productIds = [];

        $wishlist->map(function (ClientWishlistInterface $wishlist) use (&$productIds) {
            $productIds[] = $wishlist->getProduct()->getId();
        });

        $conditions = new ConditionsCollection();
        $conditions->add(new In('id', $productIds));

        return $conditions;
    }
}
