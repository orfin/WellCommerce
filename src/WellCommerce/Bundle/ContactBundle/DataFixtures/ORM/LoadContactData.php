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

namespace WellCommerce\Bundle\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\ContactBundle\Entity\Contact;
use WellCommerce\Bundle\ContactBundle\Entity\ContactTranslation;
use WellCommerce\Bundle\DoctrineBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadContactData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadContactData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        if (!$this->isEnabled()) {
            return;
        }

        $contact = new Contact();
        $contact->setEnabled(1);

        /** @var ContactTranslation $translation */
        $translation = $contact->translate();
        $translation->setName('Sales department');
        $translation->setEmail('sales@domain.org');
        $translation->setBusinessHours($this->getBusinessHours());
        $translation->setCity('');
        $translation->setCountry('');
        $translation->setLine1('');
        $translation->setLine2('');
        $translation->setPostalCode('');
        $translation->setState('');
        $translation->setPhone('555 123-345-678');

        $contact->mergeNewTranslations();
        $manager->persist($contact);
        $manager->flush();

        $this->setReference('contact', $contact);
    }

    protected function getBusinessHours()
    {
        $hours = [
            'mon: 9am-5:30pm',
            'tue: 9am-5:30pm',
            'wed: 9am-5:30pm',
            'thu: 9am-5:30pm',
            'fri: 9am-5:30pm',
            'sat: 10am-2pm',
            'sun: not available'
        ];

        return implode('<br />', $hours);
    }
}
