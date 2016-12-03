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

/**
 * Class Meta
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Meta
{
    protected $title       = '';
    protected $keywords    = '';
    protected $description = '';
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    
    public function getKeywords(): string
    {
        return $this->keywords;
    }
    
    public function setKeywords(string $keywords)
    {
        $this->keywords = $keywords;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}
