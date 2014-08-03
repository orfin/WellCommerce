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

namespace WellCommerce\Core\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Appearance
 *
 * @package WellCommerce\Core\DataGrid\Configuration
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
            'column_select',
            'column_options',
        ]);

        $resolver->setOptional([
            'header',
            'filter',
            'footer',
            'max_height',
        ]);

        $resolver->setDefaults([
            'column_select'  => false,
            'column_options' => true,
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