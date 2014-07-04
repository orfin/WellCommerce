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
namespace WellCommerce\Plugin\Client\Form;

use WellCommerce\Core\Component\Form\AbstractForm;
use WellCommerce\Core\Component\Form\FormBuilder;
use WellCommerce\Core\Component\Form\FormInterface;
use WellCommerce\Plugin\Client\Model\Client;

/**
 * Class ClientForm
 *
 * @package WellCommerce\Plugin\Client\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $form = $builder->addForm($options);

        $requiredData = $form->addChild($builder->addFieldset([
            'name'  => 'required_data',
            'label' => $this->trans('Required data')
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'first_name',
            'label' => $this->trans('First name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('First name is required')),
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'last_name',
            'label' => $this->trans('Last name'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Last name is required')),
            ]
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'  => 'email',
            'label' => $this->trans('E-mail'),
            'rules' => [
                $builder->addRuleRequired($this->trans('E-mail is required')),
                $builder->addRuleCustom($this->trans('E-mail address is not valid'), function ($value) {
                    return filter_var($value, FILTER_VALIDATE_EMAIL);
                }),
                $builder->addRuleUnique($this->trans('E-mail already exists'), [
                    'table'   => 'client',
                    'column'  => 'email',
                    'exclude' => [
                        'column' => 'id',
                        'values' => $this->getParam('id')
                    ]
                ])
            ]
        ]));

        $requiredData->addChild($builder->addPassword([
            'name'  => 'password',
            'label' => $this->trans('Password'),
            'rules' => [
                $builder->addRuleRequired($this->trans('Password is required')),
            ]
        ]));

        $requiredData->addChild($builder->addSelect([
            'name'    => 'client_group_id',
            'label'   => $this->trans('Group'),
            'options' => $builder->makeOptions($this->get('client_group.repository')->getAllClientGroupToSelect())
        ]));

        $requiredData->addChild($builder->addTextField([
            'name'    => 'discount',
            'label'   => $this->trans('Discount'),
            'comment' => $this->trans('Discount for client'),
            'suffix'  => '%',
            'rules'   => [
                $builder->addRuleCustom($this->trans('Discount must be between 0-100'), function ($value) {
                    return ($value >= 0 && $value <= 100);
                })
            ],
            'filters' => [
                $builder->addFilterCommaToDotChanger()
            ],
        ]));

        $requiredData->addChild($builder->addCheckbox([
            'name'    => 'active',
            'label'   => $this->trans('Active'),
            'default' => 1,
            'comment' => $this->trans('Only active users can login into administration area')
        ]));

        $form->addFilters([
            $builder->addFilterNoCode(),
            $builder->addFilterTrim(),
            $builder->addFilterSecure()
        ]);

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareData(Client $user)
    {
        $formData = [];
        $accessor = $this->getPropertyAccessor();
        $accessor->setValue($formData, '[required_data]', $user->attributesToArray());

        return $formData;
    }
}
