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

namespace WellCommerce\Core\DataGrid;

/**
 * Class Renderer
 *
 * @package WellCommerce\Core\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Renderer
{
    private $dataGrid;

    public function __construct(DataGridInterface $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }

    public function render()
    {
        $content
            = <<<EOF

EOF;

        return $content;
    }
} 