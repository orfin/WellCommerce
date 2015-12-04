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
class ImageHelper implements ImageHelperInterface
{
    /**
     * @var \Liip\ImagineBundle\Imagine\Cache\CacheManager
     */
    private $manager;

    /**
     * Constructor
     *
     * @param CacheManager $manager
     */
    public function __construct(CacheManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($path, $filter, array $config = [])
    {
        return $this->manager->getBrowserPath($path, $filter, $config);
    }
}
