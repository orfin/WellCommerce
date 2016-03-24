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

namespace WellCommerce\Component\Tests\Elements\Button;

use WellCommerce\Component\Form\Elements\Button\Button;
use WellCommerce\Component\Form\Test\AbstractElementTestCase;

/**
 * Class ArrayCollectionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ButtonTest extends AbstractElementTestCase
{
    protected function getInstance()
    {
        return new Button();
    }

    protected function getRequiredOptions()
    {
        return [
            'name'  => 'button_name',
            'label' => 'button_label',
            'icon'  => ''
        ];
    }
}
