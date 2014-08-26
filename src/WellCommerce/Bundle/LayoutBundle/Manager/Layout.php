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

namespace WellCommerce\Bundle\LayoutBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Layout
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @Annotation
 */
class Layout implements LayoutInterface
{
    /**
     * @var string Layout name
     */
    public $name;

    /**
     * @var bool Cache status
     */
    public $cacheEnabled;

    /**
     * @var int Cache lifetime in seconds
     */
    public $ttl;

    public $theme;

    private $columns;

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
    public function isCacheEnabled()
    {
        return (bool)$this->cacheEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheTtl()
    {
        return (int)$this->ttl;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}