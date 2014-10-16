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
namespace WellCommerce\Bundle\AvailabilityBundle\Form;

use WellCommerce\Bundle\FormBundle\Form\AbstractForm;
use WellCommerce\Bundle\FormBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\FormBundle\Form\FormInterface;

/**
 * Class AvailabilityForm
 *
 * @package WellCommerce\Availability\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($builder->getElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data.label')
        ]));

        $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'translations',
            'label' => $this->trans('form.required_data.language_data.label')
        ]))
            ->addChild($builder->getElement('text_field', [
                'name'  => 'name',
                'label' => $this->trans('availability.name'),
            ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }
}
