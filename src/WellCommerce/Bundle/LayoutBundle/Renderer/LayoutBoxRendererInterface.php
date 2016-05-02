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

namespace WellCommerce\Bundle\LayoutBundle\Renderer;

/**
 * Interface LayoutBoxRendererInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayoutBoxRendererInterface
{
    /**
     * Forwards request to box controller and returns rendered template
     *
     * @param string $identifier Box identifier
     * @param array  $params     Parameters to override
     *
     * @return string
     */
    public function render(string $identifier, array $params) : string;
}
