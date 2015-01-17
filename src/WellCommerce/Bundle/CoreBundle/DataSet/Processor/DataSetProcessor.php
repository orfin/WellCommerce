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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Processor;

use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class DataSetProcessor
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetProcessor implements ProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function processResult(DataSetInterface $dataset, $result, $total, DataSetRequestInterface $request)
    {
        $transformers = $dataset->getTransformers();
        if ($transformers->count()) {
            $result = $this->transformResult($result, $transformers);
        }

        return [
            'data_id'       => $request->getId(),
            'rows_num'      => $total,
            'starting_from' => $request->getOffset(),
            'total'         => $total,
            'filtered'      => count($result),
            'rows'          => $result
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function transformResult($rows, TransformerCollection $transformers)
    {
        $result = [];

        foreach ($rows as $row) {
            $result[] = $this->processRow($row, $transformers);
        }

        return $result;
    }

    protected function processRow($row, TransformerCollection $transformers)
    {
        foreach ($row as $field => $value) {
            if ($transformers->has($field)) {
                $row[$field] = $transformers->get($field)->transform($value);
            }
        }

        return $row;
    }
}
