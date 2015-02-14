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

namespace WellCommerce\Bundle\SeoBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\DataSetAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;

/**
 * Interface SeoRepositoryInterface
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
interface SeoRepositoryInterface extends RepositoryInterface, DataSetAwareRepositoryInterface
{
}
