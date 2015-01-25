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

namespace WellCommerce\Bundle\DataSetBundle\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

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
            'id',
            'offset',
            'limit',
            'orderBy',
            'orderDir',
            'conditions',
        ]);

        $resolver->setDefaults([
            'id'         => 0,
            'offset'     => 0,
            'conditions' => null,
        ]);

        $resolver->setAllowedTypes([
            'id'         => ['numeric'],
            'offset'     => ['numeric'],
            'limit'      => ['numeric'],
            'orderBy'    => ['string'],
            'orderDir'   => ['string'],
            'conditions' => ['null', 'WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->options['id'];
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
        return $this->options['orderBy'];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderDir()
    {
        return $this->options['orderDir'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConditions()
    {
        return $this->options['conditions'];
    }
}
