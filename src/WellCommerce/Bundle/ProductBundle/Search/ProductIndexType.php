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

namespace WellCommerce\Bundle\ProductBundle\Search;

use WellCommerce\Bundle\SearchBundle\Type\IndexTypeField;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeFieldCollection;
use WellCommerce\Bundle\SearchBundle\Type\IndexTypeInterface;

/**
 * Class ProductIndexType
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductIndexType implements IndexTypeInterface
{
    const INDEX_TYPE_NAME = 'product';
    
    public function getName() : string
    {
        return self::INDEX_TYPE_NAME;
    }
    
    public function getFields() : IndexTypeFieldCollection
    {
        $collection = new IndexTypeFieldCollection();
        $collection->add(new IndexTypeField('sku', [
                'indexable',
                'boost',
                'path_expression'
            ]
        ));
    }
}
