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
namespace WellCommerce\Bundle\CurrencyBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRepositoryInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class CurrencyFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $form)
    {
        $requiredData = $form->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $requiredData->addChild($this->getElement('select', [
            'name'    => 'code',
            'label'   => $this->trans('currency.label.code'),
            'options' => $this->getCurrencyRepository()->getCurrenciesToSelect()
        ]));

        $requiredData->addChild($this->getElement('checkbox', [
            'name'    => 'enabled',
            'label'   => $this->trans('common.label.enabled'),
            'comment' => $this->trans('currency.comment.enabled'),
        ]));

        $form->addFilter($this->getFilter('no_code'));
        $form->addFilter($this->getFilter('trim'));
        $form->addFilter($this->getFilter('secure'));
    }

    private function getCurrencyRepository() : CurrencyRepositoryInterface
    {
        return $this->get('currency.repository');
    }
}
