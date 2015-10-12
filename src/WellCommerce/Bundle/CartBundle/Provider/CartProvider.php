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

use WellCommerce\Bundle\CoreBundle\Provider\ResourceProvider;

/**
 * Class CartProvider
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartProvider extends ResourceProvider implements CartProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCartIdentifier()
    {
        if (null !== $this->currentResource) {
            return $this->currentResource->getId();
        }

        return 0;
    }
}
