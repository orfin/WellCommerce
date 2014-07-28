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
     * Returns start offset for results
     *
     * @return int
     */
    public function getStartingFrom();

    /**
     * Returns limit
     *
     * @return int
     */
    public function getLimit();

    /**
     * Returns column name used for sorting results
     *
     * @return mixed
     */
    public function getOrderBy();

    /**
     * Returns the sorting direction
     *
     * @return string
     */
    public function getOrderDir();

    /**
     * Returns where conditions
     *
     * @return array
     */
    public function getWhere();
} 