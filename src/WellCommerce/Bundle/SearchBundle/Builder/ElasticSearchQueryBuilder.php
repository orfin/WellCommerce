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

namespace WellCommerce\Bundle\SearchBundle\Builder;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ElasticSearchQueryBuilder implements SearchQueryBuilderInterface
{
    private $queries = [];

    public function buildFromRequest(Request $request)
    {
        $phrase = $request->get('phrase');
        $author = (int)$request->get('author');

        if ($author === 1) {
            $this->queries['match_phrase'] = [
                "author" => $phrase
            ];
        } else {
            $this->queries['query_string'] = [
                'phrase_slop'                  => 1,
                'auto_generate_phrase_queries' => true,
                "fields"                       => ["name_pl^5", "author"],
                "query"                        => $phrase . '*'
            ];
        }
    }

    public function getQuery()
    {
        return $this->queries;
    }
}
