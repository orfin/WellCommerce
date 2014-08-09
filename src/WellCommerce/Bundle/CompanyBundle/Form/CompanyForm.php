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

use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Company\Model\Company;

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
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'          => 'name',
            'label'         => $this->trans('Name'),
            'rules'         => [
                $builder->addRuleRequired($this->trans('Name is required')),
            ],
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'shortName',
            'label' => $this->trans('Short name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Short name is required')),
            ],
        ]));

        $addressData = $form->addChild($builder->addFieldset([
            'name'  => 'address_data',
            'label' => $this->trans('Address data')
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'street',
            'label' => $this->trans('Street'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'streetNo',
            'label' => $this->trans('Street number'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'flatNo',
            'label' => $this->trans('Flat number'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'province',
            'label' => $this->trans('Province'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'postCode',
            'label' => $this->trans('Post code'),
        ]));

        $addressData->addChild($builder->addTextField([
            'name'  => 'city',
            'label' => $this->trans('City'),
        ]));

        $addressData->addChild($builder->addSelect([
            'name'  => 'country',
            'label' => $this->trans('Country'),
            //            'options' => $builder->makeOptions($this->get('country.repository')->all())
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * Prepares form data using retrieved model
     *
     * @param Company $company Model
     *
     * @return array
     */
    public function prepareData(Company $company)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();

        $accessor->setValue($formData, '[required_data]', [
            'name'       => $company->name,
            'short_name' => $company->short_name
        ]);

        $accessor->setValue($formData, '[address_data]', [
            'street'   => $company->street,
            'streetno' => $company->streetno,
            'flatno'   => $company->flatno,
            'province' => $company->province,
            'postcode' => $company->postcode,
            'city'     => $company->city,
            'country'  => $company->country
        ]);

        return $formData;
    }
}
