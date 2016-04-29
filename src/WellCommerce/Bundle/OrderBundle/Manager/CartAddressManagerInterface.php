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

namespace WellCommerce\Bundle\OrderBundle\Manager;

use WellCommerce\Bundle\OrderBundle\Entity\CartInterface;
use WellCommerce\Bundle\OrderBundle\Entity\CartProductInterface;
use WellCommerce\Bundle\OrderBundle\Exception\AddCartItemException;
use WellCommerce\Bundle\OrderBundle\Repository\CartRepositoryInterface;
use WellCommerce\Bundle\ClientBundle\Entity\ClientInterface;
use WellCommerce\Bundle\CoreBundle\Manager\Front\AbstractFrontManager;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;
use WellCommerce\Bundle\ProductBundle\Entity\VariantInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopInterface;

/**
 * Interface CartAddressManagerInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CartAddressManagerInterface
{
}
