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
namespace WellCommerce\Bundle\LayoutBundle\Form;

use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class LayoutPageForm
 *
 * @package WellCommerce\LayoutPage\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $layoutPages = $this->get('layout_page.repository')->findAll();

        $form = $builder->init($options);

        /**
         * @var \WellCommerce\Bundle\LayoutBundle\Entity\LayoutPage $layoutPage
         */
        foreach ($layoutPages as $layoutPage) {

            $columnData = $form->addChild($builder->getElement('fieldset', [
                'name'  => 'layout_page_' . $layoutPage->getId(),
                'label' => $layoutPage->getName()
            ]));

            $columnDataColumns = $columnData->addChild($builder->getElement('fieldset_repeatable', [
                'name'       => 'columns_data',
                'repeat_min' => 1,
                'repeat_max' => ElementInterface::INFINITE
            ]));

            $columnDataColumns->addChild($builder->getElement('tip', [
                'tip'         => '<p>' . $this->trans('To extend the column to all remaining width please enter') . ' <strong>0</strong>.</p>',
                'retractable' => false
            ]));

            $columnDataColumns->addChild($builder->getElement('text_field', [
                'name'    => 'width',
                'label'   => $this->trans('Width'),
                'rules'   => [
                    $builder->getRule('required', [
                        'message' => $this->trans('Width is required')
                    ]),
                ],
                'default' => 0
            ]));

            $columnDataColumns->addChild($builder->getElement('layout_boxes_list', [
                'name'  => 'layout_boxes',
                'label' => $this->trans('Choose boxes'),
                'boxes' => []
            ]));
        }


        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
