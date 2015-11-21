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

namespace WellCommerce\CoreBundle\Component\DataSet\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\CoreBundle\Component\DataSet\Conditions\ConditionsCollection;

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
     * @return ConditionsCollection
     */
    public function getConditions();
}
