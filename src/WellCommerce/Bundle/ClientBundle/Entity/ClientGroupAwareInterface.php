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
 * Interface ClientGroupAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientGroupAwareInterface
{
    /**
     * @param ClientGroupInterface $clientGroup
     */
    public function setClientGroup(ClientGroupInterface $clientGroup);
    
    /**
     * @return ClientGroupInterface
     */
    public function getClientGroup();
}
