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

namespace WellCommerce\Bundle\LayoutBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;

/**
 * LayoutPageColumnBox
 *
 * @ORM\Table("layout_page_column_box")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\LayoutBundle\Repository\LayoutPageColumnBoxRepository")
 */
class LayoutPageColumnBox
{
    use ORMBehaviors\Timestampable\Timestampable;
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
     * @ORM\Column(name="span", type="integer")
     */
    private $span;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumn", inversedBy="boxes")
     * @ORM\JoinColumn(name="layout_page_column_id", referencedColumnName="id", nullable=false)
     */
    protected $column;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox")
     * @ORM\JoinColumn(name="layout_box_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $box;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getSpan()
    {
        return $this->span;
    }

    public function setSpan($span)
    {
        $this->span = $span;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function setColumn(LayoutPageColumn $column)
    {
        $this->column = $column;
    }

    public function getBox()
    {
        return $this->box;
    }

    public function setBox(LayoutBox $box)
    {
        $this->box = $box;
    }

}
