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
 * Class ContactDetailsTrait
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
trait ContactDetailsTrait
{
    /**
     * @var ContactDetailsInterface
     */
    protected $contactDetails;

    /**
     * @return mixed
     */
    public function getContactDetails()
    {
        return $this->contactDetails;
    }

    /**
     * @param mixed $contactDetails
     */
    public function setContactDetails(ContactDetailsInterface $contactDetails)
    {
        $this->contactDetails = $contactDetails;
    }
}
