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
    /**
     * @var string
     */
    protected $title;
    
    /**
     * @var string
     */
    protected $keywords;
    
    /**
     * @var string
     */
    protected $description;
    
    /**
     * Constructor
     *
     * @param string $title
     * @param string $keywords
     * @param string $description
     */
    public function __construct($title = '', $keywords = '', $description = '')
    {
        $this->title       = $title;
        $this->keywords    = $keywords;
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
