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

namespace WellCommerce\Bundle\ThemeBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class ThemeCss
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeCss extends AbstractEntity implements ThemeCssInterface
{
    use Timestampable;
    use ThemeAwareTrait;
    
    /**
     * @var string
     */
    protected $class;
    
    /**
     * @var string
     */
    protected $selector;
    
    /**
     * @var string
     */
    protected $attribute;
    
    /**
     * @return string
     */
    public function getAttribute() : string
    {
        return $this->attribute;
    }
    
    /**
     * @param string $attribute
     */
    public function setAttribute(string $attribute)
    {
        $this->attribute = $attribute;
    }
    
    /**
     * @return string
     */
    public function getClass() : string
    {
        return $this->class;
    }
    
    /**
     * @param string $class
     */
    public function setClass(string $class)
    {
        $this->class = $class;
    }
    
    /**
     * @return string
     */
    public function getSelector() : string
    {
        return $this->selector;
    }
    
    /**
     * @param string $selector
     */
    public function setSelector(string $selector)
    {
        $this->selector = $selector;
    }
}
