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

namespace WellCommerce\Bundle\SearchBundle\Type;

/**
 * Interface IndexTypeFieldInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface IndexTypeFieldInterface
{
    public function getName() : string;
    
    public function isIndexable() : bool;

    public function getBoost() : float;

    public function getPathExpression() : string;
}
