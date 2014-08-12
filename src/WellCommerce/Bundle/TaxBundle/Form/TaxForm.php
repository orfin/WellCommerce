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
namespace WellCommerce\Bundle\TaxBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BaseSubjectInterface;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\TaxBundle\Repository\TaxRepositoryInterface;

/**
 * Class TaxForm
 *
 * @package WellCommerce\Tax\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxForm extends AbstractForm implements FormInterface
{
    /**
     * @var TaxRepositoryInterface
     */
    private $repository;

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

        $requiredData->addChild($builder->getElement('text_field', [
            'name'    => 'value',
            'label'   => $this->trans('tax.required_data.value.label'),
            'rules'   => [
                $builder->getRule('required', [
                    'message' => $this->trans('Value is required')
                ]),
            ],
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ]
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'  => 'language_data',
            'label' => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('tax.language_data.name.label'),
            'rules' => [
                $builder->getRule('required', [
                    'message' => $this->trans('Name is required')
                ]),
            ]
        ]));

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    public function setDefaults(OptionsResolverInterface $resolver)
    {

    }

    /**
     * Prepares form data using retrieved entity
     *
     * @param Tax $tax Model
     *
     * @return array
     */
    public function getDefaultData(Tax $tax)
    {
        $formData     = [];
        $languageData = [];
        $accessor     = $this->getPropertyAccessor();
        $translations = $tax->getTranslations();

        foreach ($translations as $translation) {
            $languageData['name'][$translation->getLocale()] = $translation->getName();
        }

        $accessor->setValue($formData, '[required_data]', [
            'value'         => $tax->getValue(),
            'language_data' => $languageData
        ]);

        return $formData;
    }

    /**
     * Sets client group repository
     *
     * @param TaxRepositoryInterface $repository
     */
    public function setRepository(TaxRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
