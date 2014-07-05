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

namespace WellCommerce\Plugin\AddressType\Type;

use WellCommerce\Core\Component\Form\FormBuilder;

/**
 * Class Billing
 *
 * @package WellCommerce\Plugin\AddressType\Type
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Billing implements AddressTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'billing';
    }

    public function getFields(FormBuilder)
    {

    }
} 