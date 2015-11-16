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
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\MetaDataTrait;
use WellCommerce\Bundle\CommonBundle\ORM\LocaleAwareInterface;
use WellCommerce\Bundle\CommonBundle\Entity\Behaviours\RoutableTrait;
use WellCommerce\Bundle\CommonBundle\Entity\RoutableSubjectInterface;

/**
 * Class ProductStatusTranslation
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusTranslation implements LocaleAwareInterface, RoutableSubjectInterface
{
    use Translation;
    use MetaDataTrait;
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
     * @return ProductRoute|\WellCommerce\Bundle\CommonBundle\Entity\RouteInterface
     */
    public function getRouteEntity()
    {
        return new ProductStatusRoute();
    }
}
