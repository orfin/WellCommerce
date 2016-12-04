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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\OrderBundle\Entity\OrderAwareTrait;

/**
 * Class Shipment
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Shipment implements ShipmentInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;
    use OrderAwareTrait;
    
    protected $guid          = '';
    protected $packageNumber = '';
    protected $courier       = '';
    protected $sent          = false;
    protected $formData      = [];
    
    public function __construct()
    {
        $this->guid = $this->generateGuid();
    }
    
    public function getGuid(): string
    {
        return $this->guid;
    }
    
    public function setGuid(string $guid)
    {
        $this->guid = $guid;
    }
    
    public function getPackageNumber(): string
    {
        return $this->packageNumber;
    }
    
    public function setPackageNumber(string $packageNumber)
    {
        $this->packageNumber = $packageNumber;
    }

    public function getCourier(): string
    {
        return $this->courier;
    }
    
    public function setCourier(string $courier)
    {
        $this->courier = $courier;
    }
    
    public function isSent(): bool
    {
        return $this->sent;
    }
    
    public function setSent(bool $sent)
    {
        $this->sent = $sent;
    }
    
    public function getFormData(): array
    {
        return $this->formData;
    }
    
    public function setFormData(array $formData)
    {
        $this->formData = $formData;
    }
    
    private function generateGuid(): string
    {
        mt_srand((double)microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $guid   = substr($charid, 0, 32);
        
        return $guid;
    }
}
