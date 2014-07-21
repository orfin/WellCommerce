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

namespace WellCommerce\Core\DataGrid\Options;

use WellCommerce\Core\DataGrid\Configuration\Appearance;

/**
 * Class OptionsInterface
 *
 * @package WellCommerce\Core\DataGrid\Options
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionsInterface
{
    /**
     * Sets appearance options for DataGrid
     *
     * @param Appearance $appearance
     *
     * @return void
     */
    public function setAppearance(Appearance $appearance);
} 