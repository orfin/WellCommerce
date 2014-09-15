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

namespace WellCommerce\Bundle\AttributeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class AttributeGroup
 *
 * @package WellCommerce\Bundle\AttributeBundle\Entity
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="attribute_group")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\AttributeBundle\Repository\AttributeGroupRepository")
 */
class AttributeGroup
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\Attribute", inversedBy="groups")
     * @ORM\JoinTable(name="attribute_group_attribute",
     *      joinColumns={@ORM\JoinColumn(name="attribute_group_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $attributes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    /**
     * Returns group id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns group attributes
     *
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets collection of attributes
     *
     * @param ArrayCollection $collection
     */
    public function setAttributes(ArrayCollection $collection)
    {
        $this->attributes = $collection;
    }
}

