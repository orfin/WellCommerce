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

namespace WellCommerce\Bundle\ClientBundle\Entity;

/**
 * Class ClientDetailsAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ClientDetailsAwareTrait
{
    protected $clientDetails;
    
    public function getClientDetails() : ClientDetailsInterface
    {
        return $this->clientDetails;
    }
    
    public function setClientDetails(ClientDetailsInterface $clientDetails)
    {
        $this->clientDetails = $clientDetails;
    }
    
    public function hasClientDetails() : bool
    {
        return $this->clientDetails instanceof ClientDetailsInterface;
    }
}
