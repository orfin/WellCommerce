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

namespace WellCommerce\Component\DataSet\Cache;

/**
 * Class CacheOptions
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class CacheOptions
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @var array
     */
    private $tags;

    /**
     * CacheOptions constructor.
     *
     * @param bool  $enabled
     * @param int   $ttl
     * @param array $tags
     */
    public function __construct(bool $enabled = false, int $ttl = 3600, array $tags = [])
    {
        $this->enabled = $enabled;
        $this->ttl     = $ttl;
        $this->tags    = $tags;
    }

    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    public function getTtl() : int
    {
        return $this->ttl;
    }

    public function getTags() : array
    {
        return $this->tags;
    }
}
