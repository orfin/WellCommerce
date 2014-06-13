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

namespace WellCommerce\Core\Component\DataGrid\Column;

/**
 * Class DataGridColumn
 *
 * @package WellCommerce\Core\Component\DataGrid\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataGridColumn implements ColumnInterface
{
    /**
     * Column options
     *
     * @var array
     */
    private $options = [];

    /**
     * Constructor
     *
     * @param array $options DataGridColumn options
     */
    public function __construct(array $options)
    {
        $this->options = $this->configureOptions($options);
    }

    /**
     * Configure column options
     *
     * @param array $options
     *
     * @return array
     */
    private function configureOptions(array $options)
    {
        return array_replace_recursive([
            'editable'         => false,
            'selectable'       => false,
            'process_function' => false,
            'sorting'          => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance'       => [
                'visible' => true,
                'width'   => ColumnInterface::WIDTH_AUTO,
                'align'   => ColumnInterface::ALIGN_RIGHT
            ],
            'filter'           => [
                'type' => ColumnInterface::FILTER_NONE
            ]
        ], $options);
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
    public function getSource()
    {
        return $this->options['source'];
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

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessFunction()
    {
        return $this->options['process_function'];
    }
} 