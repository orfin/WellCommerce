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

/**
 * Class Appearance
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Appearance extends AbstractOptions
{
    const ALIGN_LEFT   = 'GF_Datagrid.ALIGN_LEFT';
    const ALIGN_CENTER = 'GF_Datagrid.ALIGN_CENTER';
    const ALIGN_RIGHT  = 'GF_Datagrid.ALIGN_RIGHT';
    const WIDTH_AUTO   = 'GF_Datagrid.WIDTH_AUTO';

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'visible',
            'width',
            'align',
            'no_title',
        ]);

        $resolver->setDefaults([
            'visible'  => true,
            'width'    => self::WIDTH_AUTO,
            'align'    => self::ALIGN_LEFT,
            'no_title' => false,
        ]);

        $resolver->setAllowedValues('visible', [true, false]);
        $resolver->setAllowedValues('align', [self::ALIGN_LEFT, self::ALIGN_CENTER, self::ALIGN_RIGHT]);
        $resolver->setAllowedValues('no_title', [true, false]);

        $resolver->setAllowedTypes('visible', 'bool');
        $resolver->setAllowedTypes('width', ['int', 'string']);
        $resolver->setAllowedTypes('align', 'string');
        $resolver->setAllowedTypes('no_title', 'bool');
    }
}
