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

namespace WellCommerce\Plugin\Product\Layout;

use WellCommerce\Core\Layout\Page\LayoutPage;
use WellCommerce\Core\Layout\Page\LayoutPageInterface;

/**
 * Class ProductLayoutPage
 *
 * @package WellCommerce\Plugin\Product\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductLayoutPage extends LayoutPage implements LayoutPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLayoutXml()
    {
        return 'product.xml';
    }
}