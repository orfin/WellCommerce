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

namespace WellCommerce\Component\DataGrid\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface OptionInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionInterface
{
    const GF_NULL      = -9999;
    const TYPE_NUMBER  = 'integer';
    const TYPE_STRING  = 'string';
    const TYPE_BOOLEAN = 'boolean';

    /**
     * Configures datagrid options
     *
     * @param OptionsResolver $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolver $resolver);
}
