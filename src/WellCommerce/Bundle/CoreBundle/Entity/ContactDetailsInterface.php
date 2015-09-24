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
 * Interface ContactDetailsInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ContactDetailsInterface
{
    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getSecondaryPhone();

    /**
     * @param string $secondaryPhone
     */
    public function setSecondaryPhone($secondaryPhone);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);
}
