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

namespace WellCommerce\Bundle\UserBundle\Repository;

use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @package WellCommerce\Bundle\ClientBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface UserRepositoryInterface extends DataGridAwareRepositoryInterface, RepositoryInterface
{

}