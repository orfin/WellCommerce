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

namespace WellCommerce\Bundle\NewsBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\AppBundle\Entity\Meta;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableTrait;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class NewsTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class NewsTranslation implements RoutableSubjectInterface, LocaleAwareInterface
{
    use Translation;
    use RoutableTrait;
    
    /**
     * @var string
     */
    protected $topic;
    
    /**
     * @var string
     */
    protected $summary;
    
    /**
     * @var string
     */
    protected $content;
    
    /**
     * @var Meta
     */
    protected $meta;
    
    /**
     * @var NewsRoute
     */
    protected $route;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->meta = new Meta();
    }
    
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }
    
    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }
    
    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }
    
    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }
    
    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }
    
    /**
     * @param Meta $meta
     */
    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }
    
    public function getRouteEntity() : RouteInterface
    {
        return new NewsRoute();
    }
}
