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

namespace WellCommerce\Component\DataGrid\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class Column
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column implements ColumnInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'id',
            'caption',
            'sorting',
            'appearance',
            'filter',
        ]);

        $resolver->setDefaults([
            'appearance' => new Appearance(),
            'sorting'    => new Sorting(),
            'filter'     => new Filter(),
            'editable'   => false,
            'selectable' => false,
        ]);

        $resolver->setAllowedTypes('appearance', Appearance::class);
        $resolver->setAllowedTypes('sorting', Sorting::class);
        $resolver->setAllowedTypes('filter', Filter::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId() : string
    {
        return $this->options['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getEditable() : bool
    {
        return $this->options['editable'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectable() : bool
    {
        return $this->options['selectable'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCaption() : string
    {
        return $this->options['caption'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSorting() : Sorting
    {
        return $this->options['sorting'];
    }

    /**
     * {@inheritdoc}
     */
    public function getAppearance() : Appearance
    {
        return $this->options['appearance'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter() : Filter
    {
        return $this->options['filter'];
    }
}
