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

namespace WellCommerce\Bundle\ReviewBundle\Form\Front;

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
        $form->addChild($this->getElement('text_field', [
            'name'  => 'nick',
            'label' => $this->trans('review.label.nick'),
        ]));

        $form->addChild($this->getElement('hidden', [
            'name'  => 'rating',
            'label' => $this->trans('review.label.rating'),
        ]));

        $form->addChild($this->getElement('hidden', [
            'name'  => 'ratingLevel',
            'label' => $this->trans('review.label.rating'),
        ]));

        $form->addChild($this->getElement('hidden', [
            'name'  => 'ratingRecommendation',
            'label' => $this->trans('review.label.rating'),
        ]));

        $form->addChild($this->getElement('text_area', [
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
