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

namespace WellCommerce\Bundle\ProducerBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\AppBundle\Entity\Meta;
use WellCommerce\Bundle\LocaleBundle\Entity\LocaleAwareInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\RoutingBundle\Entity\RoutableTrait;
use WellCommerce\Bundle\RoutingBundle\Entity\RouteInterface;

/**
 * Class ProducerTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerTranslation implements RoutableSubjectInterface, LocaleAwareInterface
{
    use Translation;
    use RoutableTrait;
    
    protected $name             = '';
    protected $shortDescription = '';
    protected $description      = '';
    protected $meta;
    
    public function __construct()
    {
        $this->meta = new Meta();
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }
    
    public function setShortDescription(string $shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description)
    {
        $this->description = $description;
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
        return new ProducerRoute();
    }
}
