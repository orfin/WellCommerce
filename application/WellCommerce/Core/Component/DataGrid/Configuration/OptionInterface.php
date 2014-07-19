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
 * Interface OptionInterface
 *
 * @package WellCommerce\Core\Component\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OptionInterface
{
    const GF_NULL = -9999;

    /**
     * Every component must contain configuration for its options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return mixed
     */
    public function configureOptions(OptionsResolverInterface $resolver);
} 