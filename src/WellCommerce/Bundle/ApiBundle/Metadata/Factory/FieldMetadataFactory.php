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

namespace WellCommerce\Bundle\ApiBundle\Metadata\Factory;

use WellCommerce\Bundle\ApiBundle\Metadata\FieldMetadata;

/**
 * Class FieldMetadataFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FieldMetadataFactory
{
    /**
     * Creates a field metadata for given name and parameters
     *
     * @param string $fieldName
     * @param array  $parameters
     *
     * @return FieldMetadata
     */
    public function create($fieldName, array $parameters)
    {
        $metadata = new FieldMetadata($fieldName, $parameters);

        return $metadata;
    }
}
