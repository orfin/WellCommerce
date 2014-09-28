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

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * LayoutBox
 *
 * @ORM\Table("layout_box")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxRepository")
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
    private $id;

    /**
     * @ORM\Column(name="box_type", type="string")
     */
    private $boxType;

    /**
     * @var string
     *
     * @ORM\Column(name="settings", type="json_array", nullable=true)
     */
    private $settings;

    /**
     * @var string
     *
     * @ORM\Column(name="visibility", type="integer", nullable=true, options={"default":1})
     */
    private $visibility;

    /**
     * @ORM\Column(name="show_header", type="boolean", nullable=true, options={"default":1})
     */
    private $showHeader;

    /**
     * @ORM\Column(name="identifier", type="string")
     */
    private $identifier;

    public function getId()
    {
        return $this->id;
    }

    public function getBoxType()
    {
        return $this->boxType;
    }

    public function setBoxType($boxType)
    {
        $this->boxType = $boxType;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    public function getShowHeader()
    {
        return $this->showHeader;
    }

    public function setShowHeader($showHeader)
    {
        $this->showHeader = $showHeader;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}
