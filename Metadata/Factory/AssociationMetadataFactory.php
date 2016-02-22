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

use WellCommerce\Bundle\ApiBundle\Metadata\AssociationMetadata;

/**
 * Class AssociationMetadataFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AssociationMetadataFactory
{
    /**
     * Creates an association metadata for given name and parameters
     *
     * @param string $associationName
     * @param array  $parameters
     *
     * @return AssociationMetadata
     */
    public function create($associationName, array $parameters)
    {
        $metadata = new AssociationMetadata($associationName, $parameters);

        return $metadata;
    }
}
