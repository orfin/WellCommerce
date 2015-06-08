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

namespace WellCommerce\Bundle\IntlBundle\Provider;

use WellCommerce\Bundle\CoreBundle\Provider\ProviderInterface;

/**
 * Interface CurrencyProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyProviderInterface extends ProviderInterface
{
    /**
     * Returns all currencies as array
     *
     * @return array
     */
    public function getSelect();
}
