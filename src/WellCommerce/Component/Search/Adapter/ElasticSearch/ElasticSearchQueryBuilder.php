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

namespace WellCommerce\Component\Search\Adapter\ElasticSearch;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Component\Search\Adapter\AbstractQueryBuilder;
use WellCommerce\Component\Search\Model\FieldInterface;

/**
 * Class ElasticSearchQueryBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class ElasticSearchQueryBuilder extends AbstractQueryBuilder
{
    protected function createMultiFieldSearch(Collection $fields)
    {
        $matches = [];

        $fields->map(function (FieldInterface $field) use (&$matches) {
            $matches[] = [
                'query_string' => [
                    'default_field' => $field->getName(),
                    'query'         => $field->getValue(),
                    'boost'         => $field->getBoost(),
                    "fuzziness"     => $field->getFuzziness(),
                ]
            ];
        });

        return [
            'query' => [
                'bool' => [
                    'should'               => [
                        $matches
                    ],
                    'minimum_should_match' => $fields->count() - 1
                ],
            ]
        ];
    }

    protected function createSimpleSearch(string $phrase)
    {
        $configuration = [];

        $this->request->getType()->getFields()->map(function (FieldInterface $field) use (&$configuration) {
            $configuration[] = sprintf('%s^%s', $field->getName(), $field->getBoost());
        });

        return [
            'template' => [
                'inline' => [
                    "simple_query_string" => [
                        'query'  => '{{query_string}}*',
                        'fields' => $configuration
                    ]
                ],
                'params' => [
                    'query_string' => $phrase
                ]
            ]
        ];
    }
}
