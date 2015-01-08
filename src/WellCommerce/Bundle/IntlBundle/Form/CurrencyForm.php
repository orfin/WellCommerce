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
namespace WellCommerce\Bundle\IntlBundle\Form;

use WellCommerce\Bundle\CoreBundle\Form\Builder\AbstractFormBuilder;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\FormInterface;
use WellCommerce\Bundle\IntlBundle\Repository\CurrencyRepositoryInterface;

/**
 * Class CurrencyForm
 *
 * @package WellCommerce\Bundle\IntlBundle\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyForm extends AbstractFormBuilder implements FormBuilderInterface
{
    /**
     * @var CurrencyRepositoryInterface
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $form = $builder->init($options);

        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('form.required_data')
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('currency.code'),
            'options' => $this->repository->getCurrenciesToSelect()
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));

        return $form;
    }

    /**
     * Sets currency repository
     *
     * @param CurrencyRepositoryInterface $repository
     */
    public function setRepository(CurrencyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
