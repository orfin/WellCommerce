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
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;

/**
 * Class ShippingMethod
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="shipping_method")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepository")
 */
class ShippingMethod
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use EnableableTrait;
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="calculator", type="string", length=64, nullable=true)
     */
    private $calculator;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns shipping method processor
     *
     * @return string
     */
    public function getCalculator()
    {
        return $this->calculator;
    }

    /**
     * Sets shipping method calculator
     *
     * @param $calculator
     */
    public function setCalculator($calculator)
    {
        $this->calculator = $calculator;
    }
}
