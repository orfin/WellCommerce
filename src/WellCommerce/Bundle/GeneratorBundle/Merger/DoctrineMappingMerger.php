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

namespace WellCommerce\Bundle\GeneratorBundle\Merger;

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;

/**
 * Class DoctrineMappingMerger
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DoctrineMappingMerger extends AbstractContainerAware implements MergerInterface
{
    const MAPPING_FILENAME_PATTERN = '*.orm.yml';
    const MAPPING_PATH_PATTERN     = 'src/*/*/*/Resources/config/doctrine';

    public function merge()
    {
        echo 1;die();
    }
}
