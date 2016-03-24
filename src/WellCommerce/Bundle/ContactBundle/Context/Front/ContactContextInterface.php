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

namespace WellCommerce\Bundle\ContactBundle\Context\Front;

use WellCommerce\Bundle\ContactBundle\Entity\ContactInterface;

/**
 * Interface ContactContextInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContactContextInterface
{
    /**
     * @param ContactInterface $contact
     */
    public function setCurrentContact(ContactInterface $contact);

    /**
     * @return ContactInterface
     */
    public function getCurrentContact() : ContactInterface;

    /**
     * @return bool
     */
    public function hasCurrentContact() : bool;
}
