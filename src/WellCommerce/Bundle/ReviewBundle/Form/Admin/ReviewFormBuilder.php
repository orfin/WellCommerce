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
namespace WellCommerce\Bundle\ReviewBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ReviewFormBuilder
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $mainData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $mainData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('common.label.enabled'),
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'nick',
            'label' => $this->trans('review.label.nick'),
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'rating',
            'label' => $this->trans('review.label.rating'),
        ]));

        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'ratingLevel',
            'label' => $this->trans('review.label.rating_level'),
        ]));


        $mainData->addChild($this->getElement('text_field', [
            'name'  => 'ratingRecommendation',
            'label' => $this->trans('review.label.rating_recommendation'),
        ]));

        $mainData->addChild($this->getElement('text_area', [
            'name'  => 'review',
            'label' => $this->trans('review.label.review'),
            'rows'  => 5,
            'cols'  => 10
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }
}
