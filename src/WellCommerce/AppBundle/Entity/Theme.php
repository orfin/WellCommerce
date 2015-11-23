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

namespace WellCommerce\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

/**
 * Class Theme
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Theme implements ThemeInterface
{
    use Timestampable, Blameable;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $folder;

    /**
     * @var Collection|ThemeCssInterface[]
     */
    protected $css;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * {@inheritdoc}
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     * {@inheritdoc}
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * {@inheritdoc}
     */
    public function setCss(Collection $css)
    {
        $this->css = $css;
    }
}
