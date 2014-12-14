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

namespace WellCommerce\Bundle\CompanyBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\DataSetBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;

/**
 * Interface CompanyRepositoryInterface
 *
 * @package WellCommerce\Bundle\CompanyBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CompanyRepositoryInterface extends RepositoryInterface, DataSetAwareRepositoryInterface, DataGridAwareRepositoryInterface
{

} 