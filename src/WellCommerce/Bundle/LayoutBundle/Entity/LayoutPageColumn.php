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
 * LayoutPageColumn
 *
 * @ORM\Table("layout_page_column")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\LayoutBundle\Repository\LayoutPageColumnRepository")
 */
class LayoutPageColumn
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
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutPage", inversedBy="columns")
     * @ORM\JoinColumn(name="layout_page_id", referencedColumnName="id", nullable=false)
     */
    protected $page;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme", inversedBy="columns")
     * @ORM\JoinColumn(name="layout_theme_id", referencedColumnName="id", nullable=false)
     */
    protected $theme;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutPageColumnBox", mappedBy="column", cascade={"persist"}, orphanRemoval=true)
     */
    private $boxes;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(LayoutPage $page)
    {
        $this->page = $page;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setTheme(LayoutTheme $theme)
    {
        $this->theme = $theme;
    }

    public function getBoxes()
    {
        return $this->boxes;
    }

}
