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

namespace WellCommerce\Bundle\AppBundle\Service\LayoutBox\Renderer;

use WellCommerce\Bundle\AppBundle\Manager\Front\LayoutBoxManager;

/**
 * Class LayoutBoxRenderer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxRenderer implements LayoutBoxRendererInterface
{
    /**
     * @var LayoutBoxManager
     */
    protected $layoutBoxManager;

    /**
     * Constructor
     *
     * @param LayoutBoxManager $layoutBoxManager
     */
    public function __construct(LayoutBoxManager $layoutBoxManager)
    {
        $this->layoutBoxManager = $layoutBoxManager;
    }

    /**
     * Renders a layout box
     *
     * @param string $identifier
     * @param array  $params
     *
     * @return string
     */
    public function render($identifier, $params)
    {
        $content = $this->layoutBoxManager->getLayoutBoxContent($identifier, $params);

        return $content->getContent();
    }
}
