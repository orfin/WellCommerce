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

namespace WellCommerce\Bundle\CartBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\AbstractProvider;

/**
 * Class CartProductProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProductProvider extends AbstractProvider implements CartProductProviderInterface
{
    /**
     * @var null|array
     */
    protected $dataset = null;

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        if (null === $this->dataset) {
            $this->dataset = $this->getCollectionBuilder()->getDataSet([
                'order_by' => 'name',
            ]);
        }

        return $this->dataset;
    }
}
