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

    /**
     * @var string
     */
    protected $guid;
    
    /**
     * @var string
     */
    protected $packageNumber;
    
    /**
     * @var string
     */
    protected $courier;
    
    /**
     * @var bool
     */
    protected $sent;
    
    /**
     * @var array
     */
    protected $formData;
    
    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }
    
    /**
     * @param string $guid
     */
    public function setGuid(string $guid)
    {
        $this->guid = $guid;
    }
    
    /**
     * @return string
     */
    public function getPackageNumber(): string
    {
        return $this->packageNumber;
    }
    
    /**
     * @param string $packageNumber
     */
    public function setPackageNumber(string $packageNumber)
    {
        $this->packageNumber = $packageNumber;
    }
    
    /**
     * @return string
     */
    public function getCourier(): string
    {
        return $this->courier;
    }
    
    /**
     * @param string $courier
     */
    public function setCourier(string $courier)
    {
        $this->courier = $courier;
    }
    
    /**
     * @return boolean
     */
    public function isSent(): bool
    {
        return $this->sent;
    }
    
    /**
     * @param boolean $sent
     */
    public function setSent(bool $sent)
    {
        $this->sent = $sent;
    }
    
    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }
    
    /**
     * @param array $formData
     */
    public function setFormData(array $formData)
    {
        $this->formData = $formData;
    }
}
