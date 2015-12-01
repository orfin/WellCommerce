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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Transformer;

use WellCommerce\Component\DataSet\Transformer\AbstractDataSetTransformer;

/**
 * Class VersionReferenceTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class VersionReferenceTransformer extends AbstractDataSetTransformer
{
    public function transformValue($reference)
    {
        if (null !== $reference) {
            return substr($reference, 0, 10);
        }

        return null;
    }
}
