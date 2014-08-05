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

namespace WellCommerce\Bundle\CoreBundle\Layout;

/**
 * Class Layout
 *
 * @package WellCommerce\Bundle\CoreBundle\Layout
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Layout implements LayoutInterface
{
    /**
     * @var string Layout name
     */
    private $name;

    /**
     * @var bool Cache status
     */
    private $cacheEnabled;

    /**
     * @var int Cache lifetime in seconds
     */
    private $ttl;

    /**
     * Constructor
     *
     * @param string $name
     * @param bool   $cache
     * @param int    $ttl
     */
    public function __construct($name, $cache, $ttl)
    {
        $this->name         = $name;
        $this->cacheEnabled = (bool)$cache;
        $this->ttl          = (int)$ttl;
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
} 