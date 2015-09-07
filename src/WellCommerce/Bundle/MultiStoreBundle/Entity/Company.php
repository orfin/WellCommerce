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

namespace WellCommerce\Bundle\MultiStoreBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\AddressTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;

/**
 * Class Company
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Company
{
    use Timestampable, Blameable, AddressTrait, PhotoTrait;
    
    /**
     * @var integer
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $shortName;
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getShortName()
    {
        return $this->shortName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }
}
