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

use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class LayoutBox
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox extends AbstractEntity implements LayoutBoxInterface
{
    use Timestampable;
    use Translatable;
    use Blameable;

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
    public function getBoxType() : string
    {
        return $this->boxType;
    }

    /**
     * {@inheritdoc}
     */
    public function setBoxType(string $boxType)
    {
        $this->boxType = $boxType;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings() : array
    {
        return $this->settings;
    }

    /**
     * {@inheritdoc}
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }
}
