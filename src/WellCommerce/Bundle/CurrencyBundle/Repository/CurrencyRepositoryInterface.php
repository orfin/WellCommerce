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

namespace WellCommerce\Bundle\CurrencyBundle\Repository;

use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface CurrencyRepositoryInterface
 *
 * @package WellCommerce\Bundle\ClientBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyRepositoryInterface extends DataGridAwareRepositoryInterface, RepositoryInterface
{
    /**
     * Returns an array of currencies fetched from intl component
     *
     * @return mixed
     */
    public function getCurrenciesToSelect();

}