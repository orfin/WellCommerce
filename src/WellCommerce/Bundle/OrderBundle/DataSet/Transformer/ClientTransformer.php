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

namespace WellCommerce\Bundle\OrderBundle\DataSet\Transformer;

use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class ClientTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientTransformer extends AbstractDataSetTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transformValue($value)
    {
        list($firstName, $lastName, $email) = explode(':', $value);

        return sprintf('<strong>%s %s</strong><br/>%s', $firstName, $lastName, $email);
    }
}
