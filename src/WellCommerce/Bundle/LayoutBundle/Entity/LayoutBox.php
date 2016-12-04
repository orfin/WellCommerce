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
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;

/**
 * Class LayoutBox
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBox implements LayoutBoxInterface
{
    use IdentifiableTrait;
    use Timestampable;
    use Translatable;
    use Blameable;
    
    protected $boxType    = '';
    protected $identifier = '';
    protected $settings   = [];
    
    public function getBoxType(): string
    {
        return $this->boxType;
    }
    
    public function setBoxType(string $boxType)
    {
        $this->boxType = $boxType;
    }
    
    public function getSettings(): array
    {
        return $this->settings;
    }
    
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }
    
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }
}
