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
namespace WellCommerce\Layout\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\Elements\ElementInterface;
use WellCommerce\Core\Component\Form\FormBuilderInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Core\Component\Model\Collection\CustomCollection;

/**
 * Class LayoutPageForm
 *
 * @package WellCommerce\LayoutPage\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageForm extends AbstractForm implements FormInterface
{
    private $layoutBoxes;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form              = $builder->addForm($options);
        $layoutPages       = $this->get('layout_page.repository')->all();
        $this->layoutBoxes = $this->get('layout_box.repository')->all();

        foreach ($layoutPages as $page) {

            $columnData = $form->addChild($builder->addFieldset([
                'name'  => 'layout_page_' . $page->id,
                'label' => $page->name
            ]));

            $columnDataColumns = $columnData->addChild($builder->addFieldsetRepeatable([
                'name'       => 'columns_data',
                'repeat_min' => 1,
                'repeat_max' => ElementInterface::INFINITE
            ]));

            $columnDataColumns->addChild($builder->addTip([
                'tip'         => '<p>' . $this->trans('To extend the column to all remaining width please enter') . ' <strong>0</strong>.</p>',
                'retractable' => false
            ]));

            $columnDataColumns->addChild($builder->addTextField([
                'name'    => 'width',
                'label'   => $this->trans('Width'),
                'rules'   => [
                    $builder->addRuleRequired('Column width is required')
                ],
                'default' => 0
            ]));

            $boxes = $this->getBoxesForPage($page->name);

            $boxData = $columnDataColumns->addChild($builder->addLayoutBoxesList([
                'name'  => 'layout_boxes',
                'label' => $this->trans('Choose boxes'),
                'boxes' => $builder->makeOptions($boxes)
            ]));
        }

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Returns only boxes available for chosen page
     *
     * @param $page
     *
     * @return array
     */
    public function getBoxesForPage($page)
    {
        $boxes = [];
        foreach ($this->layoutBoxes as $box) {
            $configurator = $this->getLayoutManager()->getLayoutBoxConfigurator($box->type);
            if ($configurator->isAvailableForLayoutPage($page)) {
                $boxes[$box->id] = $box->translation->first()->name;
            }
        }

        return $boxes;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(CustomCollection $layoutPageColumns)
    {
        $formData = [];

        foreach ($layoutPageColumns as $column) {

            $boxes = [];
            foreach ($column->boxes as $box) {
                $boxes[] = [
                    'box'       => $box->layout_box_id,
                    'span'      => $box->span,
                    'collapsed' => 0
                ];
            }

            $formData['layout_page_' . $column->layout_page_id]['columns_data'][$column->id] = [
                'width'        => $column->width,
                'layout_boxes' => $boxes
            ];
        }

        return $formData;
    }
}
