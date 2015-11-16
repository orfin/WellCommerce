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

namespace WellCommerce\Bundle\CmsBundle\Context\Front;

use WellCommerce\Bundle\CmsBundle\Entity\ContactInterface;

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
     * @return null|ContactInterface
     */
    public function getCurrentContact();

    /**
     * @return bool
     */
    public function hasCurrentContact();
}
