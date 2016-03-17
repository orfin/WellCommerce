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
 * Class ContactContext
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactContext implements ContactContextInterface
{
    /**
     * @var ContactInterface
     */
    protected $currentContact;

    /**
     * {@inheritdoc}
     */
    public function setCurrentContact(ContactInterface $contact)
    {
        $this->currentContact = $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentContact() : ContactInterface
    {
        return $this->currentContact;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCurrentContact() : bool
    {
        return $this->currentContact instanceof ContactInterface;
    }
}
