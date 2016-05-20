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
 * Class SearchQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ElasticSearchQueryBuilder implements SearchQueryBuilderInterface
{
    private $queries = [];

    public function addMatchQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $this->queries['query_string'] = [
            'phrase_slop'                  => 1,
            'auto_generate_phrase_queries' => true,
            "fields"                       => ["description", "name_pl^5"],
            "query"                        => $value . '*'
        ];

        return $this;
    }

    public function addFilterQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new FilterQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }

    public function addBoolQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new BoolQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }

    public function addFuzzyQuery(string $fieldName, $value) : SearchQueryBuilderInterface
    {
        $query = new FuzzyQueryType($fieldName, $value);
        $this->queries->add($query);

        return $this;
    }
    
    public function getQuery()
    {
        return $this->queries;
    }
}
