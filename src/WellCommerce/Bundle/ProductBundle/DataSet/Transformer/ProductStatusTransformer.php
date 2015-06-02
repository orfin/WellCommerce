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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Transformer;

use WellCommerce\Bundle\DataSetBundle\Transformer\TransformerInterface;

/**
 * Class ProductStatusTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusTransformer implements TransformerInterface
{
    /**
     * @var array
     */
    protected $statuses;

    /**
     * Constructor
     *
     * @param array $statuses
     */
    public function __construct(array $statuses = [])
    {
        $this->statuses = $statuses;
    }

    /**
     * Formats passed DateTime object to format
     *
     * @param string $value
     *
     * @return string
     */

    public function transform($value)
    {
        $productStatuses = explode(',', $value);
        $value           = [];

        foreach ($productStatuses as $status) {
            $information = $this->getStatusData($status);

            if (null !== $information) {
                $value[] = $information;
            }
        }

        return $value;
    }

    /**
     * Returns status information
     *
     * @param int $identifier
     *
     * @return array|null
     */
    protected function getStatusData($identifier)
    {
        foreach ($this->statuses as $status) {
            if ((int)$status['id'] === (int)$identifier) {
                return $status;
            }
        }

        return null;
    }
}
