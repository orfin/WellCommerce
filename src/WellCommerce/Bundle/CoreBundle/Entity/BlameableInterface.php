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

namespace WellCommerce\Bundle\CoreBundle\Entity;

/**
 * Interface BlameableInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface BlameableInterface
{
    public function setCreatedBy($user);
    
    public function setUpdatedBy($user);
    
    public function setDeletedBy($user);
    
    public function getCreatedBy();
    
    public function getUpdatedBy();
    
    public function getDeletedBy();
    
    public function isBlameable();
}
