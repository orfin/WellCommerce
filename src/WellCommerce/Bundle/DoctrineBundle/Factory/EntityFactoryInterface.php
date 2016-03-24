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

namespace WellCommerce\Bundle\DoctrineBundle\Factory;

use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface EntityFactoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface EntityFactoryInterface
{
    /**
     * @return EntityInterface
     */
    public function create();
}
