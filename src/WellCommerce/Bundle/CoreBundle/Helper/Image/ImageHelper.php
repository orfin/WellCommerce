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

namespace WellCommerce\Bundle\CoreBundle\Helper\Image;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;

/**
 * Class ImageHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ImageHelper implements ImageHelperInterface
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * ImageHelper constructor.
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage(string $path, string $filter, array $config = []) : string
    {
        return $this->cacheManager->getBrowserPath($path, $filter, $config);
    }
}
