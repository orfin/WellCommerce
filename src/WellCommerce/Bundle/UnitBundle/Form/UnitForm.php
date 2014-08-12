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
namespace WellCommerce\Bundle\UnitBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BaseSubjectInterface;
use WellCommerce\Bundle\UnitBundle\Entity\Unit;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\UnitBundle\Repository\UnitRepositoryInterface;

/**
 * Class UnitForm
 *
 * @package WellCommerce\Unit\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitForm extends AbstractForm implements FormInterface
{
    /**
     * @var UnitRepositoryInterface
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

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'      => 'language_data',
            'label'     => $this->trans('form.required_data.language_data.label')
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('unit.language_data.name.label'),
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

    public function setDefaults(OptionsResolverInterface $resolver){

    }
    /**
     * Prepares form data using retrieved entity
     *
     * @param Unit $unit Model
     *
     * @return array
     */
    public function getDefaultData(BaseSubjectInterface $unit)
    {
        $formData     = [];
        $languageData = [];
        $accessor     = $this->getPropertyAccessor();
        $translations = $unit->getTranslations();

        foreach($translations as $translation){
            $languageData['name'][$translation->getLocale()] = $translation->getName();
        }

        $accessor->setValue($formData, '[required_data]', [
            'language_data' => $languageData
        ]);

        return $formData;
    }

    /**
     * Sets client group repository
     *
     * @param UnitRepositoryInterface $repository
     */
    public function setRepository(UnitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
