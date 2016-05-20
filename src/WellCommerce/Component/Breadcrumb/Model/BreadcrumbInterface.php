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

namespace WellCommerce\Component\Breadcrumb\Model;

/**
 * Interface BreadcrumbInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface BreadcrumbInterface
{
    public function getLabel() : string;

    public function getCssClass() : string;

    public function getUrl() : string;
}
