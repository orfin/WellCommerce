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

namespace WellCommerce\Bundle\ClientBundle\Factory;

use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetails;
use WellCommerce\Bundle\ClientBundle\Entity\ClientContactDetailsInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class ClientContactDetailsFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ClientContactDetailsFactory extends AbstractEntityFactory
{
    public function create() : ClientContactDetailsInterface
    {
        $details = new ClientContactDetails();
        $details->setFirstName('');
        $details->setLastName('');
        $details->setEmail('');
        $details->setPhone('');
        $details->setSecondaryPhone('');
        
        return $details;
    }
}
