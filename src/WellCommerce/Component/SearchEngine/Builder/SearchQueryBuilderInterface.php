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

namespace WellCommerce\Component\SearchEngine\Builder;

/**
 * Interface SearchQueryBuilderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface SearchQueryBuilderInterface
{
    public function addMatchQuery(string $fieldName, $value) : SearchQueryBuilderInterface;

    public function addFilterQuery(string $fieldName, $value) : SearchQueryBuilderInterface;

    public function addBoolQuery(string $fieldName, $value) : SearchQueryBuilderInterface;

    public function addFuzzyQuery(string $fieldName, $value) : SearchQueryBuilderInterface;

    public function getQuery();
}
