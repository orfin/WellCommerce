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

/**
 * LayoutTheme
 *
 * @ORM\Table("layout_theme_css")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\LayoutBundle\Repository\LayoutThemeCssRepository")
 */
class LayoutThemeCss
{
    use ORMBehaviors\Timestampable\Timestampable;

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
     * @ORM\Column(name="class", type="string", length=255)
     */
    private $class;

    /**
     * @var string
     *
     * @ORM\Column(name="selector", type="string", length=255)
     */
    private $selector;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute", type="string", length=255)
     */
    private $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme", inversedBy="css")
     * @ORM\JoinColumn(name="layout_theme_id", referencedColumnName="id", nullable=false)
     */
    protected $theme;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
