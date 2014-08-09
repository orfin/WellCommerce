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
namespace WellCommerce\Bundle\CompanyBundle\Form;

use WellCommerce\Bundle\CompanyBundle\Entity\Company;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;

/**
 * Class CompanyForm
 *
 * @package WellCommerce\Company\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder->init($options);

        $requiredData = $form->addElement('fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]);

        $requiredData->addElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('Name'),
            'rules' => [
//                $form->addRule('required', [
//                    'message' => $this->trans('Name is required')
//                ])
            ]
        ]);

        $requiredData->addElement('text_field', [
            'name'  => 'shortName',
            'label' => $this->trans('Short name'),
            'rules' => [
//                $form->addRule('required', [
//                    'message' => $this->trans('Short name is required')
//                ])
            ]
        ]);

        $addressData = $form->addElement('fieldset', [
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'streetNo',
            'label' => $this->trans('Street number'),
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'flatNo',
            'label' => $this->trans('Flat number'),
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'postCode',
            'label' => $this->trans('Post code'),
        ]);

        $addressData->addElement('text_field', [
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]);

        $addressData->addElement('select', [
            'name'  => 'country',
            'label' => $this->trans('Country'),
            //            'options' => $builder->makeOptions($this->get('country.repository')->all())
        ]);

        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Prepares form data using retrieved entity
     *
     * @param Company $company Model
     *
     * @return array
     */
    public function getDefaultData(Company $company)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();

        $accessor->setValue($formData, '[required_data]', [
            'name'      => $company->getName(),
            'shortName' => $company->getShortName()
        ]);

        $accessor->setValue($formData, '[address_data]', [
            'street'   => $company->getStreet(),
            'streetNo' => $company->getStreetNo(),
            'flatNo'   => $company->getFlatNo(),
            'province' => $company->getProvince(),
            'postCode' => $company->getPostCode(),
            'city'     => $company->getCity(),
            'country'  => $company->getCountry()
        ]);

        return $formData;
    }
}
