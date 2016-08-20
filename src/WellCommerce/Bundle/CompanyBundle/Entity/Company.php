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

namespace WellCommerce\Bundle\CompanyBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class Company
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Company implements CompanyInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Blameable;

    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $shortName;

    /**
     * @var CompanyAddressInterface
     */
    protected $address;

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getShortName() : string
    {
        return $this->shortName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setShortName(string $shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress() : CompanyAddressInterface
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(CompanyAddressInterface $address)
    {
        $this->address = $address;
    }
}
