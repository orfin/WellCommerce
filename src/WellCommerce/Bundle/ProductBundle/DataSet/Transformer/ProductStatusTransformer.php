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

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Transformer\AbstractDataSetTransformer;

/**
 * Class ProductStatusTransformer
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusTransformer extends AbstractDataSetTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transformValue($value)
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
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'statuses'
        ]);

        $resolver->setDefaults([
            'statuses' => []
        ]);

        $resolver->setAllowedTypes([
            'statuses' => ['array']
        ]);
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
        foreach ($this->options['statuses'] as $status) {
            if ((int)$status['id'] === (int)$identifier) {
                return $status;
            }
        }

        return null;
    }
}
