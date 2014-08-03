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

namespace WellCommerce\Core\DataSet\Request;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Interface RequestInterface
 *
 * @package WellCommerce\Core\DataSet\Request
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface RequestInterface
{
    /**
     * Configures request options
     *
     * @param OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolverInterface $resolver);

    /**
     * Returns DataSet option by its name
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key);
}