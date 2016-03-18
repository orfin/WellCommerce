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

namespace WellCommerce\Component\DataGrid\Column\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataGrid\DataGridInterface;

/**
 * Class Filter
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Filter extends AbstractOptions
{
    const FILTER_NONE    = 'GF_Datagrid.FILTER_NONE';
    const FILTER_INPUT   = 'GF_Datagrid.FILTER_INPUT';
    const FILTER_BETWEEN = 'GF_Datagrid.FILTER_BETWEEN';
    const FILTER_TREE    = 'GF_Datagrid.FILTER_TREE';
    const FILTER_SELECT  = 'GF_Datagrid.FILTER_SELECT';

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'type',
            'options',
        ]);

        $resolver->setDefaults([
            'type'            => self::FILTER_INPUT,
            'options'         => [],
            'filtered_column' => DataGridInterface::GF_NULL,
            'source'          => DataGridInterface::GF_NULL,
            'load_children'   => DataGridInterface::GF_NULL,
        ]);

        $resolver->setNormalizer('options', function ($options, $values) {
            if (self::FILTER_SELECT === $options['type']) {
                return $this->prepareValues($values);
            }

            return [];
        });

        $resolver->setAllowedValues('type', [
            self::FILTER_SELECT,
            self::FILTER_BETWEEN,
            self::FILTER_INPUT,
            self::FILTER_NONE,
            self::FILTER_TREE,
        ]);
    }

    /**
     * Prepares values to use in filter
     *
     * @param array $values
     *
     * @return array
     */
    private function prepareValues(array $values) : array
    {
        $filterOptions = [];
        foreach ($values as $key => $value) {
            $filterOptions[] = [
                'id'      => $key,
                'caption' => $value,
            ];
        }

        return $filterOptions;
    }
}
