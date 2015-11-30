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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Class LayoutBox
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox implements LayoutBoxInterface
{
    use Timestampable;
    use Translatable;
    use Blameable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $boxType;

    /**
     * @var string
     */
    protected $settings;

    /**
     * @var string
     */
    protected $identifier;

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
    public function getBoxType()
    {
        return $this->boxType;
    }

    /**
     * {@inheritdoc}
     */
    public function setBoxType($boxType)
    {
        $this->boxType = $boxType;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
