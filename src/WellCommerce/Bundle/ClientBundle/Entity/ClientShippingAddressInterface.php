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
 * Interface ClientShippingAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientShippingAddressInterface extends ClientAddressInterface
{
    public function isCopyBillingAddress(): bool;
    
    public function setCopyBillingAddress(bool $copyBillingAddress);
    
    public function getCompanyName(): string;
    
    public function setCompanyName(string $companyName);
}
