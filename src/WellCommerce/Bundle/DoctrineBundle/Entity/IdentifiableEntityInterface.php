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

namespace WellCommerce\Bundle\DoctrineBundle\Entity;

/**
 * Interface IdentifiableEntityInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface IdentifiableEntityInterface
{
    /**
     * @return int
     */
    public function getId() : int;
}
