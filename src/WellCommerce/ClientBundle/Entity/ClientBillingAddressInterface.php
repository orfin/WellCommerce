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

namespace WellCommerce\ClientBundle\Entity;

/**
 * Interface ClientBillingAddressInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ClientBillingAddressInterface extends ClientAddressInterface
{
    /**
     * @param string $vatId
     */
    public function setVatId($vatId);

    /**
     * @return string
     */
    public function getVatId();

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getCompanyName();
}
