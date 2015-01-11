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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface DataSetRequestInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetRequestInterface
{
    /**
     * Configures request options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Returns request id
     *
     * @return int
     */
    public function getId();

    /**
     * Returns offset for LIMIT clause
     *
     * @return int
     */
    public function getOffset();

    /**
     * Returns limit for LIMIT clause
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
    public function getConditions();
}
