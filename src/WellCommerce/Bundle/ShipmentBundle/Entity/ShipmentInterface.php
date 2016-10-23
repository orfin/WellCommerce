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

namespace WellCommerce\Bundle\ShipmentBundle\Entity;

use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderAwareInterface;

/**
 * Interface ShipmentInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShipmentInterface extends EntityInterface, OrderAwareInterface
{
    /**
     * @return string
     */
    public function getGuid(): string;
    
    /**
     * @param string $guid
     */
    public function setGuid(string $guid);
    
    /**
     * @return string
     */
    public function getPackageNumber(): string;
    
    /**
     * @param string $packageNumber
     */
    public function setPackageNumber(string $packageNumber);
    
    /**
     * @return string
     */
    public function getCourier(): string;
    
    /**
     * @param string $courier
     */
    public function setCourier(string $courier);
    
    /**
     * @return boolean
     */
    public function isSent(): bool;
    
    /**
     * @param boolean $sent
     */
    public function setSent(bool $sent);
    
    
    /**
     * @return array
     */
    public function getFormData(): array;
    
    /**
     * @param array $formData
     */
    public function setFormData(array $formData);
}