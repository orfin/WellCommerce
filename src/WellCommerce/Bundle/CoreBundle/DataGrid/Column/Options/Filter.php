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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class Filter
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Filter extends AbstractOptions
{
    const FILTER_NONE    = 'GF_Datagrid.FILTER_NONE';
    const FILTER_INPUT   = 'GF_Datagrid.FILTER_INPUT';
    const FILTER_BETWEEN = 'GF_Datagrid.FILTER_BETWEEN';
    const FILTER_TREE    = 'GF_Datagrid.FILTER_TREE';
    const FILTER_SELECT  = 'GF_Datagrid.FILTER_SELECT';

    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'type',
            'options'
        ]);

        $resolver->setOptional([
            'filtered_column',
            'source',
            'load_children'
        ]);

        $resolver->setDefaults([
            'type'            => self::FILTER_INPUT,
            'options'         => [],
            'filtered_column' => DataGridInterface::GF_NULL,
            'source'          => DataGridInterface::GF_NULL,
            'load_children'   => DataGridInterface::GF_NULL,
        ]);

        $optionsNormalizer = function ($options, $values) {
            if (self::FILTER_SELECT === $options['type']) {
                return $this->prepareValues($values);
            }

            return [];
        };

        $resolver->setNormalizers([
            'options' => $optionsNormalizer
        ]);

        $resolver->setAllowedValues([
            'type' => [
                self::FILTER_SELECT,
                self::FILTER_BETWEEN,
                self::FILTER_INPUT,
                self::FILTER_NONE,
                self::FILTER_TREE
            ],
        ]);
    }

    private function prepareValues($values)
    {
        $filterOptions = [];
        foreach ($values as $key => $value) {
            $filterOptions[] = [
                'id'    => $key,
                'value' => $value
            ];
        }

        return $filterOptions;
    }
} 