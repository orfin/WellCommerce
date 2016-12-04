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
    
    protected $topic   = '';
    protected $summary = '';
    protected $content = '';
    protected $meta;
    
    public function __construct()
    {
        $this->meta = new Meta();
    }
    
    public function getTopic(): string
    {
        return $this->topic;
    }
    
    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }
    
    public function getSummary(): string
    {
        return $this->summary;
    }
    
    public function setSummary(string $summary)
    {
        $this->summary = $summary;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
    
    public function setContent(string $content)
    {
        $this->content = $content;
    }
    
    public function getMeta(): Meta
    {
        return $this->meta;
    }
    
    public function setMeta(Meta $meta)
    {
        $this->meta = $meta;
    }
    
    public function getRouteEntity(): RouteInterface
    {
        return new NewsRoute();
    }
}
