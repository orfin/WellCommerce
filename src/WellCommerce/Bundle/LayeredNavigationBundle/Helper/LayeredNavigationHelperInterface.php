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

namespace WellCommerce\Bundle\LayeredNavigationBundle\Helper;

use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Interface LayeredNavigationHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface LayeredNavigationHelperInterface
{
    const MULTI_VALUE_SEPARATOR = '_';
    const VALUE_TYPE_FLOAT      = 'float';
    const VALUE_TYPE_ARRAY      = 'array';
    const VALUE_TYPE_INTEGER    = 'integer';

    /**
     * Adds layered's navigation conditions to collection
     *
     * @param ConditionsCollection $collection
     *
     * @return ConditionsCollection
     */
    public function addLayeredNavigationConditions(ConditionsCollection $collection);

    /**
     * Generates an absolute url for replaced request params
     *
     * @return string
     */
    public function generateRedirectUrl() : string;

    /**
     * Returns true if layered navigation is enabled on current page. False otherwise.
     *
     * @return bool
     */
    public function isLayeredNavigationEnabled() : bool;
}
