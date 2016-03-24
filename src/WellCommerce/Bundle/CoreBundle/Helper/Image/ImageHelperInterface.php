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

/**
 * Interface ImageHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ImageHelperInterface
{
    /**
     * Returns the image path
     *
     * @param string $path
     * @param string $filter
     * @param array  $config
     *
     * @return string
     */
    public function getImage(string $path, string $filter, array $config = []) : string;
}
