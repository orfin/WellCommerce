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

use WellCommerce\Bundle\ApiBundle\Metadata\SerializationClassMetadata;

/**
 * Class SerializationClassMetadataFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class SerializationClassMetadataFactory
{
    /**
     * Creates a metadata object for given class and parameters
     *
     * @param string $class
     * @param array  $parameters
     *
     * @return SerializationClassMetadata
     */
    public function create($class, array $parameters)
    {
        $metadata = new SerializationClassMetadata($class, $parameters);

        return $metadata;
    }
}
