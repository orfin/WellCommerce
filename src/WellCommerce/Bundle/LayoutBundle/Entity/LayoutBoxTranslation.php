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

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;

/**
 * Class LayoutBoxTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxTranslation implements LocaleAwareInterface
{
    use Translation;
    
    protected $name    = '';
    protected $content = '';
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
