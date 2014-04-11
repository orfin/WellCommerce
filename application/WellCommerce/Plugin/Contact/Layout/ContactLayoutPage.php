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

namespace WellCommerce\Plugin\Contact\Layout;

use WellCommerce\Core\Form;
use WellCommerce\Core\Layout\Page\LayoutPage;
use WellCommerce\Core\Layout\Page\LayoutPageInterface;

/**
 * Class ContactPageLayoutConfigurator
 *
 * @package WellCommerce\Plugin\Contact\Configurator\Box
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactLayoutPage extends LayoutPage implements LayoutPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Contact';
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'Contact';
    }
}