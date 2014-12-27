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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Column
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column extends AbstractColumn implements ColumnInterface
{
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'alias',
            'source',
            'aggregated',
            'sortable',
        ]);

        $resolver->setDefined([
            'transformer'
        ]);

        $resolver->setDefaults([
            'aggregated' => false,
            'sortable'   => false
        ]);

        $resolver->setAllowedTypes([
            'transformer' => 'WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerInterface'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->options['alias'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSource()
    {
        return $this->options['source'];
    }

    /**
     * {@inheritdoc}
     */
    public function getRawSelect()
    {
        return sprintf('%s AS %s', $this->options['source'], $this->options['alias']);
    }

    /**
     * {@inheritdoc}
     */
    public function isAggregated()
    {
        return $this->options['aggregated'];
    }

    /**
     * {@inheritdoc}
     */
    public function isSortable()
    {
        return $this->options['sortable'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTransformer()
    {
        return $this->options['transformer'];
    }

    /**
     * {@inheritdoc}
     */
    public function hasTransformer()
    {
        return (isset($this->options['transformer']) && null !== $this->options['transformer']);
    }
}