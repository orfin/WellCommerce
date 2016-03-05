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
            'limit'      => 100,
            'order_by'   => 'name',
            'order_dir'  => 'asc',
            'conditions' => new ConditionsCollection(),
        ]);

        $resolver->setNormalizer('offset', function (Options $options, $value) {
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

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->options['offset'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->options['limit'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderBy()
    {
        return $this->options['order_by'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderDir()
    {
        $order = strtolower($this->options['order_dir']);

        return in_array($order, ['asc', 'desc']) ? $order : 'asc';
    }

    /**
     * {@inheritdoc}
     */
    public function getConditions()
    {
        return $this->options['conditions'];
    }
}
