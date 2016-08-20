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

namespace WellCommerce\Bundle\ContactBundle\Factory;

use WellCommerce\Bundle\ContactBundle\Entity\Contact;
use WellCommerce\Bundle\ContactBundle\Entity\ContactInterface;
use WellCommerce\Bundle\ContactBundle\Entity\ContactTranslation;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractEntityFactory;

/**
 * Class ContactFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactFactory extends AbstractEntityFactory
{
    public function create() : ContactInterface
    {
        $contact = new Contact();
        $contact->setEnabled(true);
        $contact->setCreatedAt(new \DateTime());

        /** @var ContactTranslation $translation */
        $translation = $contact->translate();
        $translation->setName('');
        $translation->setEmail('');
        $translation->setBusinessHours('');
        $translation->setCity('');
        $translation->setCountry('');
        $translation->setLine1('');
        $translation->setLine2('');
        $translation->setPostalCode('');
        $translation->setState('');
        $translation->setPhone('');

        return $contact;
    }
}
