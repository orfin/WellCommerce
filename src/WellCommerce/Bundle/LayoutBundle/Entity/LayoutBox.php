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

namespace WellCommerce\Bundle\LayoutBundle\Entity;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class LayoutBox
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox
{
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Blameable\Blameable;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="box_type", type="string", length=255, nullable=false)
     */
    protected $boxType;

    /**
     * @var string
     *
     * @ORM\Column(name="settings", type="json_array", nullable=false)
     */
    protected $settings;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=255, nullable=false)
     */
    protected $identifier;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBoxType()
    {
        return $this->boxType;
    }

    /**
     * @param $boxType
     */
    public function setBoxType($boxType)
    {
        $this->boxType = $boxType;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
