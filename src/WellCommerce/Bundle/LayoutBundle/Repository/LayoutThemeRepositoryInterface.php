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

namespace WellCommerce\Bundle\LayoutBundle\Repository;

use WellCommerce\Bundle\CoreBundle\DataGrid\Repository\DataGridAwareRepositoryInterface;
use WellCommerce\Bundle\CoreBundle\Repository\RepositoryInterface;
use WellCommerce\Bundle\LayoutBundle\Entity\LayoutTheme;
use WellCommerce\Bundle\LayoutBundle\Manager\Layout;

/**
 * Interface LayoutThemeRepositoryInterface
 *
 * @package WellCommerce\Bundle\LayoutBundle\Repository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutThemeRepositoryInterface extends RepositoryInterface, DataGridAwareRepositoryInterface
{
    /**
     * Returns columns for passed layout and theme
     *
     * @param LayoutTheme $theme
     * @param Layout      $layout
     *
     * @return mixed
     */
    public function getLayoutColumns(LayoutTheme $theme, Layout $layout);

    /**
     * Returns layout theme
     *
     * @param $themeId
     *
     * @return LayoutTheme
     */
    public function find($themeId);
} 