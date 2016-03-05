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
        $contact->translate('en')->setName('Sales department');
        $contact->translate('en')->setEmail('sales@domain.org');
        $contact->translate('en')->setPhone('555 123-345-678');
        $contact->translate('en')->setBusinessHours($this->getBusinessHours());
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
