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

namespace WellCommerce\Core\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Appearance
 *
 * @package WellCommerce\Core\Component\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Appearance extends AbstractOption implements OptionInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'header',
            'filter',
            'footer',
            'column_select',
            'column_options',
            'max_height',
        ]);

        $resolver->setDefaults([
            'header'         => true,
            'filter'         => true,
            'footer'         => true,
            'column_select'  => true,
            'column_options' => true,
            'max_height'     => 0,
        ]);

        $resolver->setAllowedTypes([
            'header'         => 'bool',
            'filter'         => 'bool',
            'footer'         => 'bool',
            'column_select'  => 'bool',
            'column_options' => 'bool',
            'max_height'     => 'int',
        ]);
    }
}