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

namespace WellCommerce\Bundle\DataSetBundle\Transformer;

/**
 * Interface TransformerInterface
 *
 * @package WellCommerce\Bundle\DataSetBundle\Transformer
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface TransformerInterface
{
    public function transform($value);
}
