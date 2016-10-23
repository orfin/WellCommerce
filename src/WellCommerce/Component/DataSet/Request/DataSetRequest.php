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

namespace WellCommerce\Component\DataSet\Request;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataSet\Conditions\ConditionInterface;
use WellCommerce\Component\DataSet\Conditions\ConditionsCollection;

/**
 * Class DataSetRequest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetRequest implements DataSetRequestInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'offset',
            'page',
            'limit',
            'order_by',
            'order_dir',
            'conditions',
        ]);

        $resolver->setDefaults([
            'offset'     => 0,
            'page'       => 1,
            'limit'      => 150,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => new ConditionsCollection(),
        ]);

        $resolver->setNormalizer('offset', function (Options $options) {
            $page  = $options['page'];
            $limit = $options['limit'];

            return ($page * $limit) - $limit;
        });

        $resolver->setAllowedTypes('offset', 'numeric');
        $resolver->setAllowedTypes('page', 'numeric');
        $resolver->setAllowedTypes('limit', 'numeric');
        $resolver->setAllowedTypes('order_by', 'string');
        $resolver->setAllowedTypes('order_dir', 'string');
        $resolver->setAllowedTypes('conditions', ConditionsCollection::class);
    }

    public function getOffset() : int
    {
        return $this->options['offset'];
    }

    public function getLimit() : int
    {
        return $this->options['limit'];
    }

    public function getOrderBy() : string
    {
        return $this->options['order_by'];
    }

    public function getOrderDir() : string
    {
        $order = strtolower($this->options['order_dir']);

        return in_array($order, ['asc', 'desc']) ? $order : 'asc';
    }

    public function getConditions() : ConditionsCollection
    {
        return $this->options['conditions'];
    }

    public function addCondition(ConditionInterface $condition)
    {
        $this->getConditions()->add($condition);
    }
}
