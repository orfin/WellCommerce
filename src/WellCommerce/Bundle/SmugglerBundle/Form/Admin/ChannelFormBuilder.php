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
namespace WellCommerce\Bundle\SmugglerBundle\Form\Admin;

use WellCommerce\Bundle\CoreBundle\Form\AbstractFormBuilder;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class ChannelFormBuilder
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ChannelFormBuilder extends AbstractFormBuilder
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormInterface $unitForm)
    {
        $channelRequiredData = $unitForm->addChild($this->getElement('nested_fieldset', [
            'name'  => 'required_data',
            'label' => $this->trans('common.fieldset.general')
        ]));

        $channelRequiredData->addChild($this->getElement('text_field', [
            'name'  => 'name',
            'label' => $this->trans('common.label.name'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $channelRequiredData->addChild($this->getElement('text_field', [
            'name'  => 'url',
            'label' => $this->trans('common.label.url'),
            'rules' => [
                $this->getRule('required')
            ],
        ]));

        $unitForm->addFilter($this->getFilter('no_code'));
        $unitForm->addFilter($this->getFilter('trim'));
        $unitForm->addFilter($this->getFilter('secure'));
    }
}
