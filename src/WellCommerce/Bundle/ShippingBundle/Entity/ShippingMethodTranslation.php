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

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;

/**
 * ShippingTranslation
 *
 * @ORM\Table(name="shipping_method_translation")
 * @ORM\Entity
 */
class ShippingMethodTranslation implements LocaleAwareInterface
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * Returns shipping method name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets shipping method name
     *
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
