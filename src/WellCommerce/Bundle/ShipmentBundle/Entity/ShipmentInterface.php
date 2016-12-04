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
    public function getGuid(): string;
    
    public function setGuid(string $guid);
    
    public function getPackageNumber(): string;
    
    public function setPackageNumber(string $packageNumber);
    
    public function getCourier(): string;
    
    public function setCourier(string $courier);
    
    public function isSent(): bool;
    
    public function setSent(bool $sent);
    
    public function getFormData(): array;
    
    public function setFormData(array $formData);
}