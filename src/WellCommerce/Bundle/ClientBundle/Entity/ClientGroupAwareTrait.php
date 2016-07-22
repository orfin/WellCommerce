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
 * Class ClientGroupAwareTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ClientGroupAwareTrait
{
    /**
     * @var ClientGroupInterface
     */
    protected $clientGroup;
    
    public function getClientGroup()
    {
        return $this->clientGroup;
    }
    
    public function setClientGroup(ClientGroupInterface $clientGroup = null)
    {
        $this->clientGroup = $clientGroup;
    }
}
