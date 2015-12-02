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

namespace WellCommerce\Bundle\ProductBundle\Helper;

use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Interface ProductLayeredNavigationHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductLayeredNavigationHelperInterface
{
    const MULTIVALUE_SEPARATOR = '_';

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
    public function generateRedirectUrl();

    /**
     * Returns true if layered navigation is enabled on current page. False otherwise.
     *
     * @return bool
     */
    public function isLayeredNavigationEnabled();

    /**
     * Filters given identifiers and returns only allowed producers
     *
     * @param array $identifiers
     *
     * @return array
     */
    public function filterProducers(array $identifiers = []);

    /**
     * Filters given identifiers and returns only allowed attributes
     *
     * @param array $identifiers
     *
     * @return array
     */
    public function filterAttributes(array $identifiers = []);
}
