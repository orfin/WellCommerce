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

namespace WellCommerce\SalesBundle\Repository;

use WellCommerce\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface PaymentMethodRepositoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface PaymentMethodRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns default shipping method
     *
     * @return null|\WellCommerce\SalesBundle\Entity\PaymentMethodInterface
     */
    public function getDefaultPaymentMethod();
}
