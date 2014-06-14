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
namespace WellCommerce\Plugin\Layout\Form;

use WellCommerce\Core\Component\Form\AbstractFormBuilder;
use WellCommerce\Core\Component\Form\Elements\ElementInterface;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Layout\Event\LayoutPageFormEvent;

/**
 * Class LayoutPageForm
 *
 * @package WellCommerce\Plugin\LayoutPage\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageForm extends AbstractFormBuilder implements FormInterface
{
    /**
     * Initializes layout_theme Form
     *
     * @param array $layoutThemeData
     *
     * @return Form\Elements\Form
     */
    public function init($layoutThemeData = [])
    {
        $form = $this->addForm([
            'name' => 'layout_columns',
        ]);

        $pages = $this->get('layout_page.repository')->all();
        $layoutBoxConfigurators = $this->getLayoutManager()->getLayoutBoxConfigurators();

        foreach ($pages as $page) {
            $columnData = $form->addChild($this->addFieldset([
                'name'  => $page->id,
                'label' => $page->name
            ]));

            $columnDataColumns = $columnData->addChild($this->addFieldsetRepeatable([
                'name'       => 'columns_data',
                'repeat_min' => 1,
                'repeat_max' => ElementInterface::INFINITE
            ]));

            $columnDataColumns->addChild($this->addTip([
                'tip'         => '<p>' . $this->trans('To extend the column to all remaining width please enter') . ' <strong>0</strong>.</p>',
                'retractable' => false
            ]));

            $boxData = $columnDataColumns->addChild($this->addLayoutBoxesList([
                'name'  => 'layout_boxes',
                'label' => $this->trans('Choose boxes'),
                'boxes' => $this->makeOptions([])
            ]));
        }

        $form->addFilters([
            $this->addFilterNoCode(),
            $this->addFilterTrim(),
            $this->addFilterSecure()
        ]);

        $event = new LayoutPageFormEvent($form, $layoutThemeData);

        $this->getDispatcher()->dispatch(LayoutPageFormEvent::FORM_INIT_EVENT, $event);

        $form->populate($event->getPopulateData());

        return $form;
    }
}
