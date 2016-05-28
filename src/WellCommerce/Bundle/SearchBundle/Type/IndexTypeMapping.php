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

use WellCommerce\Bundle\SearchBundle\Property\MappedProperty;

/**
 * Class IndexTypeMapping
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class IndexTypeMapping
{
    public function addField(string $name, bool $indexable, float $boost, MappedProperty $property)
    {
        
    }
}
