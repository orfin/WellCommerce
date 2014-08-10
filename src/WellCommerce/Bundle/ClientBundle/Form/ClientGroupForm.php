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
namespace WellCommerce\Bundle\ClientBundle\Form;

use WellCommerce\Bundle\ClientBundle\Entity\ClientGroup;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\ClientBundle\Repository\ClientGroupRepositoryInterface;

/**
 * Class ClientGroupForm
 *
 * @package WellCommerce\ClientGroup\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupForm extends AbstractForm implements FormInterface
{
    /**
     * @var ClientGroupRepositoryInterface
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
            'name'    => 'discount',
            'label'   => $this->trans('client_group.discount.label'),
            'comment' => $this->trans('client_group.discount.comment'),
            'suffix'  => '%',
            'rules'   => [
//                $builder->getRule('custom', [
//                    'message' => $this->trans('client_group.discount.rule.custom'),
//                    'function' => function ($value) {
//                            return ($value >= 0 && $value <= 100);
//                    }
//                ])
            ],
            'filters' => [
                $builder->getFilter('comma_to_dot_changer')
            ],
        ]));

        $languageData = $requiredData->addChild($builder->getElement('fieldset_language', [
            'name'      => 'language_data',
            'label'     => $this->trans('form.required_data.language_data.label'),
            'languages' => []
        ]));

        $languageData->addChild($builder->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('client_group.language_data.name.label'),
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

    /**
     * Prepares form data using retrieved entity
     *
     * @param ClientGroup $clientGroup Model
     *
     * @return array
     */
    public function getDefaultData(ClientGroup $clientGroup)
    {
        $translations = $this->repository->findTranslations($clientGroup);
        $formData     = [];
        $accessor     = $this->getPropertyAccessor();

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

    /**
     * Sets client group repository
     *
     * @param ClientGroupRepositoryInterface $repository
     */
    public function setRepository(ClientGroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
