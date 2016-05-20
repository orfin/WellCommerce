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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class BreadcrumbCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BreadcrumbCollection extends ArrayCollection
{
    public function add($value)
    {
        if (!$value instanceof BreadcrumbInterface) {
            throw new \InvalidArgumentException(sprintf('Breadcrumb element must implement interface "%s"', BreadcrumbInterface::class));
        }

        parent::add($value);
    }
}
