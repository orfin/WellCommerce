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
 * Interface ContactDetailsAwareInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContactDetailsAwareInterface
{
    /**
     * @return ContactDetails
     */
    public function getContactDetails();

    /**
     * @param ContactDetails $contactDetails
     */
    public function setContactDetails(ContactDetailsInterface $contactDetails);
}
