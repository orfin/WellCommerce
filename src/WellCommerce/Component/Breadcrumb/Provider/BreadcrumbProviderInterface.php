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

namespace WellCommerce\Component\Breadcrumb\Provider;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Breadcrumb\Model\BreadcrumbInterface;

/**
 * Interface BreadcrumbProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface BreadcrumbProviderInterface
{
    public function getBreadcrumbs() : Collection;

    public function add(BreadcrumbInterface $breadcrumb);
}
