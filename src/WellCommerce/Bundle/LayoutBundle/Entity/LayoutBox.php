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
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $boxType;

    /**
     * @var array
     */
    private $settings;

    /**
     * @var bool
     */
    private $visibility;

    /**
     * @var bool
     */
    private $showHeader;

    /**
     * @var string
     */
    private $identifier;

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
     * @return bool
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return bool
     */
    public function getShowHeader()
    {
        return $this->showHeader;
    }

    /**
     * @param $showHeader
     */
    public function setShowHeader($showHeader)
    {
        $this->showHeader = $showHeader;
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
