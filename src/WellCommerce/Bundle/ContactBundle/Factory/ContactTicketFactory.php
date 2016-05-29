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

use WellCommerce\Bundle\ContactBundle\Entity\ContactTicketInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactory;

/**
 * Class ContactTicketFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTicketFactory extends EntityFactory
{
    public function create() : ContactTicketInterface
    {
        /** @var $contact ContactTicketInterface */
        $contactTicket = $this->init();
        $contactTicket->setEmail('');
        $contactTicket->setSubject('');
        $contactTicket->setContent('');


        return $contactTicket;
    }
}
