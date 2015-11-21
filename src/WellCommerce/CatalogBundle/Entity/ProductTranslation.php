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

namespace WellCommerce\CatalogBundle\Entity;

use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\CommonBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\CommonBundle\Entity\RoutableSubjectInterface;
use WellCommerce\CommonBundle\ORM\LocaleAwareInterface;
use WellCommerce\CoreBundle\Entity\Meta;

/**
 * Class ProductTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductTranslation implements LocaleAwareInterface, RoutableSubjectInterface
{
    use Translation;
    use RoutableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $shortDescription;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Meta
     */
    protected $meta;

    /**
     * @var ProductRoute|\WellCommerce\CommonBundle\Entity\RouteInterface
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
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
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
     * @return ProductRoute|\WellCommerce\CommonBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new ProductRoute();
    }
}
