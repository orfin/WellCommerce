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

namespace WellCommerce\Bundle\ThemeBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;

/**
 * Class Theme
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Theme extends AbstractEntity implements ThemeInterface
{
    use Timestampable;
    use Blameable;
    
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
    public function getName() : string
    {
        return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getFolder() : string
    {
        return $this->folder;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setFolder(string $folder)
    {
        $this->folder = $folder;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCss() : Collection
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
