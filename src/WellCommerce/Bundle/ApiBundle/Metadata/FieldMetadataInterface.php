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
 * Interface FieldMetadataInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface FieldMetadataInterface
{
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @return array
     */
    public function getGroups();
    
    /**
     * Checks whether field is exposed for given serialization group
     *
     * @param string $group
     *
     * @return bool
     */
    public function hasGroup($group);
    
    /**
     * Checks whether field is exposed for default serialization group
     *
     * @param string $group
     *
     * @return bool
     */
    public function hasDefaultGroup();
}
