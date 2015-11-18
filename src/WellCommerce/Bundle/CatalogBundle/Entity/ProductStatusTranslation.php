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

namespace WellCommerce\Bundle\CatalogBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\CommonBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\Bundle\CommonBundle\Entity\RoutableSubjectInterface;
use WellCommerce\Bundle\CommonBundle\ORM\LocaleAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\Meta;

/**
 * Class ProductStatusTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusTranslation implements LocaleAwareInterface, RoutableSubjectInterface
{
    use Translation;
    use RoutableTrait;
    
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ProductStatusRoute|\WellCommerce\Bundle\CommonBundle\Entity\RouteInterface
     */
    protected $route;

    /**
     * @var string
     */
    protected $cssClass;

    /**
     * @var Meta
     */
    protected $meta;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
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

    /**
     * @return ProductRoute|\WellCommerce\Bundle\CommonBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new ProductStatusRoute();
    }
}
