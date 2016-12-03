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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Class HierarchyAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait HierarchyAwareTrait
{
    protected $hierarchy = 0;

    public function getHierarchy(): int
    {
        return $this->hierarchy;
    }

    public function setHierarchy(int $hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }
}
