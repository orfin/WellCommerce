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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Column;

use Symfony\Component\OptionsResolver\OptionsResolver;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Sorting;

/**
 * Class Column
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Column implements ColumnInterface
{
    private $options = [];

    public function __construct(array $options)
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'id',
            'caption',
            'sorting',
            'appearance',
            'filter',
        ]);

        $resolver->setDefined([
            'editable',
            'selectable',
        ]);

        $resolver->setDefaults([
            'appearance' => new Appearance(),
            'sorting'    => new Sorting(),
            'filter'     => new Filter(),
            'editable'   => false,
            'selectable' => false,
        ]);

        $resolver->setAllowedTypes([
            'appearance' => 'WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance',
            'sorting'    => 'WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Sorting',
            'filter'     => 'WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter',
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
    public function getEditable()
    {
        return $this->options['editable'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectable()
    {
        return $this->options['selectable'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCaption()
    {
        return $this->options['caption'];
    }

    /**
     * {@inheritdoc}
     */
    public function getSorting()
    {
        return $this->options['sorting'];
    }

    /**
     * {@inheritdoc}
     */
    public function getAppearance()
    {
        return $this->options['appearance'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter()
    {
        return $this->options['filter'];
    }
}
