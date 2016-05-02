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

namespace WellCommerce\Bundle\ApiBundle\Metadata;

/**
 * Interface SerializationClassMetadataInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SerializationClassMetadataInterface
{
    /**
     * @return string
     */
    public function getClass();
    
    /**
     * @return \WellCommerce\Bundle\ApiBundle\Metadata\Collection\FieldMetadataCollection
     */
    public function getFields();
    
    /**
     * @return \WellCommerce\Bundle\ApiBundle\Metadata\Collection\AssociationMetadataCollection
     */
    public function getAssociations();
    
    /**
     * @return array
     */
    public function getCallbacks();
}
